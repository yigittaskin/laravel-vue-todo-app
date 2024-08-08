<template>
  <div class="container">
    <h1>Todo List</h1>
    <div class="mb-3">
      <input v-model="newTodo" placeholder="Add new todo" class="form-control" />
      <button @click="addTodo" class="btn btn-primary mt-2">Add Todo</button>
    </div>
    <ul class="list-group">
      <li v-for="todo in todos" :key="todo.id" class="list-group-item">
        <span :class="{ 'text-decoration-line-through': todo.completed }">{{ todo.title }}</span>
        <button @click="toggleCompletion(todo)" class="btn btn-sm btn-secondary float-end">Toggle</button>
        <button @click="deleteTodo(todo.id)" class="btn btn-sm btn-danger float-end me-2">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      todos: [], // Tüm görevlerin tutulduğu dizi
      newTodo: '', // Yeni eklenecek görev
    };
  },
  methods: {
    fetchTodos() {
      // Tüm görevleri API'den çek
      axios.get('/api/todos')
        .then(response => {
          this.todos = response.data;
        });
    },
    addTodo() {
      // Yeni görev ekle
      if (this.newTodo.trim() === '') return;

      axios.post('/api/todos', { title: this.newTodo })
        .then(response => {
          this.todos.push(response.data);
          this.newTodo = '';
        });
    },
    toggleCompletion(todo) {
      // Görevin tamamlanma durumunu değiştir
      axios.patch(`/api/todos/${todo.id}`, { completed: !todo.completed })
        .then(response => {
          todo.completed = response.data.completed;
        });
    },
    deleteTodo(id) {
      // Görevi sil
      axios.delete(`/api/todos/${id}`)
        .then(() => {
          this.todos = this.todos.filter(todo => todo.id !== id);
        });
    }
  },
  created() {
    // Bileşen oluşturulduğunda görevleri çek
    this.fetchTodos();
  }
}
</script>

<style scoped>
.text-decoration-line-through {
  text-decoration: line-through;
}
</style>
