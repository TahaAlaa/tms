<template>
    <div>
      <h1>Task List</h1>
      <ul>
        <li v-for="task in tasks" :key="task.id">
          <h3>{{ task.title }}</h3>
          <p>{{ task.description }}</p>
          <button @click="deleteTask(task.id)">Delete</button>
        </li>
      </ul>
      <input v-model="newTask.title" placeholder="Title">
      <textarea v-model="newTask.description" placeholder="Description"></textarea>
      <button @click="addTask">Add Task</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        tasks: [],
        newTask: {
          title: '',
          description: '',
        },
      };
    },
    mounted() {
      this.getTasks();
    },
    methods: {
      async getTasks() {
        const response = await axios.get('tasks');
        this.tasks = response.data;
      },
      async addTask() {
        if (this.newTask.title && this.newTask.description) {
          const response = await axios.post('tasks', this.newTask);
          this.tasks.push(response.data);
          this.newTask.title = '';
          this.newTask.description = '';
        }
      },
      async deleteTask(id) {
        await axios.delete(`tasks/${id}`);
        this.tasks = this.tasks.filter(task => task.id !== id);
      }
    }
  };
  </script>