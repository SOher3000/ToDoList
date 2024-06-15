<template>
    <div v-if="show" class="modal">
        <div class="modal-content">
            <span class="close" @click="close">&times;</span>
            <h2 class="modal-header">Create Task</h2>
            <input v-model="name" type="text" placeholder="Enter Task" class="input-field">
            <div>
                <input v-model="description" type="text" placeholder="Enter description" class="input-field">
            </div>
            <button @click="submit" class="submit-button">Submit</button>
            <p v-show="error" class="error-message">{{ error }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "CreateComponent",
    props: {
        show: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            name: "",
            description: "",
            error: null
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        async submit() {
            try {
                const response = await axios.post('/tasks', {
                    name: this.name,
                    description: this.description
                });
                this.error = null;
                this.$emit('task-added', response.data);
                this.name = "";
                this.description = "";
                this.close();
            } catch (error) {
                this.error = error.response ? error.response.data : 'An error occurred';
            }
        }
    }
}
</script>

<style scoped>
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background-color: #282c34;
    color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 400px;
    position: relative;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
    color: #fff;
}

.modal-header {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.5em;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.input-field {
    width: 95%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #444;
    border-radius: 15px;
    background-color: #333;
    color: #fff;
}

.submit-button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #0056b3;
}

.error-message {
    color: #ff6b6b;
    margin-top: 10px;
}
</style>
