<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const todos = ref([]);
const showTodoList = ref(false);
const appConfig = ref(null);
const showForm = ref(false);

onMounted(async () => {
    appConfig.value = JSON.parse(
        window.document.getElementById('todo-sticky-note').dataset.config
    )

    const response = await axios.get(`/api/${appConfig.value.router_prefix}/todos`);
    todos.value = response.data;
});

const toggleForm = () => {
    showForm.value = !showForm.value;
};

const form = ref({
    title: "",
    description: "",
    is_done: false,
});

const toggleTodo = () => {
    showTodoList.value = !showTodoList.value;
};

const submitForm = async () => {
    const { data } = await axios.post(`/api/${appConfig.value.router_prefix}/todos`, form.value);
    todos.value.unshift(data);
    showForm.value = false;
    form.value = {
        title: "",
        description: "",
        is_done: false,
    };
};

const removeTodo = async (id) => {
    await axios.delete(`/api/${appConfig.value.router_prefix}/todos/${id}`);
  todos.value = todos.value.filter((todo) => todo.id !== id);
};

const checkTodo = async (id) => {
    const response = await axios.put(`/api/${appConfig.value.router_prefix}/todos-check/${id}`, {
        is_done: true,
    })
    .then((response) => {
        return response;
    })
    .catch((error) => {
        return error.response;
    })
    ;
    const data = response.data;
    todos.value = todos.value.map((todo) => {
        if (todo.id === id) {
            todo.is_done = true;
        }
        
        return todo;
    });
};
</script>
<template>
    <div :class="{ 'w-1/3 h-[500px] border': showTodoList }" class="absolute top-0 right-0 overflow-y-scroll">
        <div class="flex flex-col">
            <button :class="{ hidden: showTodoList }"
                class="bg-green-300 h-10 w-10 flex justify-center items-center mr-4 mt-2" @click="toggleTodo">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col" v-show="showTodoList">
            <div class="flex flex-row h-12 bg-red-200 sticky top-0">
                <div class="w-1/3 h-full flex justify-center items-center">
                    <div class="text-xl font-bold">Todo List</div>
                </div>
                <div class="w-1/3 h-full flex justify-center items-center">
                    <div class="text-xl font-bold">
                        Waiting: {{ todos.filter((todo) => !todo.is_done).length }}
                    </div>
                </div>
                <div class="w-1/3 h-full flex justify-center items-center">
                    <button class="text-xl font-bold p-2 hover:bg-green-300 bg-green-200" @click="toggleForm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
                <div class="w-1/3 h-full flex justify-center items-center">
                    <button class="text-xl font-bold p-2 hover:bg-red-300" @click="toggleTodo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="border-t flex-col p-4 flex hover:bg-gray-100 cursor-pointer"
                :class="{ 'bg-green-100': todo.is_done, hidden: showForm }" v-for="todo in todos" :key="todo.id">
                <div class="flex flex-row justify-evenly">
                    <div class="flex flex-col w-11/12">
                        <div class="text-md font-semibold w-full">
                            {{ todo.title }}
                        </div>
                        <div class="w-full">
                            {{ todo.description }}
                        </div>
                    </div>
                    <div class="h-full w-1/12 flex flex-col justify-center items-center">
                        <button class="hover:bg-red-500 bg-red-300" @click="removeTodo(todo.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button class="mt-3 hover:bg-green-500 bg-green-300" @click="checkTodo(todo.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t flex-col p-4 flex" :class="{ hidden: !showForm }">
                <div class="">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Todo Title</label>
                    <input type="text" id="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Todo Title" required v-model="form.title" />
                </div>

                <div class="mt-3">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Todo
                        Description</label>
                    <textarea type="text" id="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Todo Description" required v-model="form.description">
                                                </textarea>
                </div>
                <label class="relative inline-flex items-center cursor-pointer mt-4">
                    <input type="checkbox" value="" class="sr-only peer" v-model="form.is_done">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900 ">Is Done?</span>
                </label>
                <div class="mt-3">
                    <button @click="submitForm" class="bg-green-500 block w-full h-12 font-semibold text-white mr-4 mt-2">
                        Create Todo
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
