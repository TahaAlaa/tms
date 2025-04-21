<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const tasks = ref([])

const fetchTasks = async () => {
    try {
        // axios.defaults.withCredentials = true;
        // await axios.get('/sanctum/csrf-cookie');
        const response = await axios.get('api/tasks');
        tasks.value = response.data.data;
    } catch (error) {
        console.error('Error fetching tasks:', error);
    }
};

const updateStatus = async (taskId, newStatus) => {
    try {
        // axios.defaults.withCredentials = true;
        // await axios.get('/sanctum/csrf-cookie');
        const response = await axios.put(`api/tasks/${taskId}`, {
            status: newStatus
        });
        console.log('Status updated:', response.data);
        fetchTasks(); // Refresh the list after update
    } catch (error) {
        console.error('Error updating task status:', error);
    }
};

const showModal = ref(false);
const newTask = ref({
    title: '',
    description: '',
    priority: ''
});

const createTask = async () => {
    try {
        axios.defaults.withCredentials = true;
        // await axios.get('/sanctum/csrf-cookie'); // Just to be safe
        const response = await axios.post('api/tasks', newTask.value);
        console.log('Task Created:', response.data);
        showModal.value = false;

        // Reset form
        newTask.value = { title: '', description: '', priority: '' };

        fetchTasks(); // Refresh the list
    } catch (error) {
        console.error('Error creating task:', error);
    }
};


const deleteTask = async (taskId) => {
    try {
        await axios.delete(`api/tasks/${taskId}`);
        tasks.value = tasks.value.filter(task => task.id !== taskId); // remove from list
        console.log(`Task ${taskId} deleted`);
    } catch (error) {
        console.error(`Error deleting task ${taskId}:`, error);
    }
};

onMounted(fetchTasks);
</script>

<template>
    <Head title="My Tasks" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Tasks
            </h2>
        </template>

        

        <div class="py-12">

        <!-- Create Task Button -->
        <div class="flex justify-center mb-4">
            <button
                @click="showModal = true"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded"
            >
                + Create Task
            </button>
        </div>

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <ul v-if="tasks.length">
                        <li
                            v-for="task in tasks"
                            :key="task.id"
                            class="mb-4 border-b pb-4"
                        >
                            <h3 class="font-bold text-lg">{{ task.title }}</h3>
                            <p class="text-sm text-gray-600">{{ task.description }}</p>
                            <span class="text-xs text-gray-500 block mb-2">Priority: {{ task.priority }}</span>
                            <span class="text-xs text-blue-600 font-semibold block mb-2">Status: {{ task.status }}</span>

                            <!-- Show buttons if task is pending or processing -->
                            <div v-if="task.status === 'pending' || task.status === 'processing'" class="flex gap-2">
                                <button
                                    v-if="task.status === 'pending'"
                                    @click="updateStatus(task.id, 'processing')"
                                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded"
                                >
                                    Mark as Processing
                                </button>
                                <button 
                                    v-if="task.status === 'processing'"
                                    @click="updateStatus(task.id, 'completed')"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded"
                                >
                                    Mark as Completed
                                </button>
                            </div>

                            <div>
                                <div class="mt-2 flex gap-2">
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>

                            </div>
                        </li>
                    </ul>
                    <div v-else>
                        No tasks found.
                    </div>
                </div>
            </div>
        </div>


        
        <!-- Modal -->
<div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <h2 class="text-lg font-bold mb-4">Create New Task</h2>
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Title</label>
            <input v-model="newTask.title" type="text" class="w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea v-model="newTask.description" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Priority</label>
            <select v-model="newTask.priority" class="w-full border rounded px-3 py-2">
                <option disabled value="">Select priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <div class="flex justify-end gap-2">
            <button @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            <button @click="createTask" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Create</button>
        </div>
    </div>
</div>

    </AuthenticatedLayout>
</template>
