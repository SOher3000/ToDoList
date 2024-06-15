<template>
    <div class="main-container">
        <h1 class="header">ToDoList</h1>
        <button @click="toggleModal" class="add-task-button">
            <span class="button-icon">➕</span> <span class="button-text">Create new task</span>
        </button>
        <CreateComponent v-if="showModal" @close="toggleModal" @task-added="addTask" :show="showModal" />
        <div class="posts-container">
            <transition-group name="fade" tag="div" class="task-list">
                <div v-for="task in paginatedTasks" :key="task.id" class="task-item" :class="{ completed: task.completed }" @click="toggleTask(task)">
                    <span>{{ task.description }}</span>
                    <button @click.stop="deleteTask(task)" class="delete-button">🗑️</button>
                </div>
            </transition-group>
            <div v-if="pages > 1" class="pagination">
                <button v-for="page in pages" :key="page" @click="currentPage = page" :class="{ active: currentPage === page }">{{ page }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import CreateComponent from '@/components/CreateComponent.vue';

export default {
    name: "ListComponent",
    components: { CreateComponent },
    data() {
        return {
            tasks: [],
            showModal: false,
            currentPage: 1,
            tasksPerPage: 10
        };
    },
    computed: {
        paginatedTasks() {
            const start = (this.currentPage - 1) * this.tasksPerPage;
            return this.tasks.slice(start, start + this.tasksPerPage);
        },
        pages() {
            return Math.ceil(this.tasks.length / this.tasksPerPage);
        }
    },
    created() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            axios.get('/tasks')
                .then(response => {
                    this.tasks = response.data.data.map(task => ({ ...task, completed: false }));
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        },
        toggleTask(task) {
            task.completed = !task.completed;
        },
        deleteTask(task) {
            this.tasks = this.tasks.filter(t => t.id !== task.id);
        },
        toggleModal() {
            this.showModal = !this.showModal;
        },
        addTask(newTask) {
            this.tasks.unshift(newTask);
        }
    }
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    min-height: 100vh;
    background-color: #f0f2f5;
}

.header {
    font-size: 2.5em;
    color: #007bff;
    margin-bottom: 20px;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

.header::after {
    content: '';
    width: 100px;
    height: 3px;
    background-color: #007bff;
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
}

.add-task-button {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background-color: #2f3ee4;
    color: #fff;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 1.1em;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.add-task-button:hover {
    background-color: #0d1572;
    transform: translateY(-2px);
}

.add-task-button:active {
    background-color: #2f3ee4;
    transform: translateY(0);
}

.button-icon {
    margin-right: 10px;
    font-size: 1.5em;
}

.posts-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    max-width: 400px;
    width: 100%;
}

.task-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.task-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #e1f5fe;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.task-item:hover {
    background-color: #b3e5fc;
}

.task-item.completed span {
    text-decoration: line-through;
    color: grey;
}

.delete-button {
    background: none;
    border: none;
    color: #d32f2f;
    cursor: pointer;
    font-size: 16px;
}

.delete-button:hover {
    color: #b71c1c;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination button {
    padding: 5px 10px;
    margin: 0 5px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.pagination button.active {
    background-color: #0056b3;
}
</style>
