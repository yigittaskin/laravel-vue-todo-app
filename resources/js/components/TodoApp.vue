<template>
    <div class="todo-container">
      <header class="header">
        <div class="header-content">
          <div class="logo">
            <h1>HeyAtlas Todo App</h1>
          </div>
          <div class="input-container">
            <input v-model="newTodo" placeholder="Add a new task..." class="todo-input" />
            <button @click="addTodo" class="add-button">+</button>
          </div>
        </div>
      </header>
  
      <ul class="todo-list">
        <li v-for="todo in todos" :key="todo.id" class="todo-item" :class="{ completed: todo.completed }">
          <div class="checkbox-container">
            <input type="checkbox" v-model="todo.completed" @change="updateTodo(todo)" />
          </div>
          <span class="col-md-8 todo-title" :class="{ 'text-decoration-line-through': todo.completed }">
            {{ todo.title }}
          </span>
          <button @click="deleteTodo(todo.id)" class="delete-button">Delete</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        todos: [],
        newTodo: '',
      };
    },
    methods: {
      fetchTodos() {
        axios.get('/api/todos').then(response => {
          this.todos = response.data.map(todo => {
            todo.completed = todo.completed === "1";
            return todo;
          });
        });
      },
      addTodo() {
        if (this.newTodo.trim() === '') return;
  
        axios.post('/api/todos', { title: this.newTodo }).then(response => {
          this.todos.push(response.data);
          this.newTodo = '';
        });
      },
      deleteTodo(id) {
        axios.delete(`/api/todos/${id}`).then(() => {
          this.todos = this.todos.filter(todo => todo.id !== id);
        });
      },
      // Checkbox durumunu güncellemek için API isteği
      updateTodo(todo) {
        axios.patch(`/api/todos/${todo.id}`, { completed: todo.completed }).then(response => {
          console.log("Todo updated", response.data);
        });
      },
    },
    created() {
      this.fetchTodos();
    },
  };
  </script>