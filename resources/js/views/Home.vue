<template>

    <div class="Home">

        <section class="input-group mb-3 form-group flex-column" :class="{ 'form-group--error': $v.newTask.description.$error }">
            <article class="d-flex">
                <input type="text" class="form-control" :class="{'form-error': ($v.newTask.description.$error) || (submitStatus === 'ERROR' && newTask.description === '')}" placeholder="Nouvelle Tâche" aria-label="Recipient's username" aria-describedby="button-addon2" v-model.trim="$v.newTask.description.$model" @keypress.enter="createTask">
                <div class="input-group-append">
                    <button class="btn btn-primary" @click="createTask"><i class="fas fa-paper-plane px-2"></i></button>
                </div>
            </article>
            <span class="error" v-if="$v.newTask.description.$error">Field is required</span>
            <p class="typo__p error" v-if="submitStatus === 'ERROR' && newTask.description === ''">Please fill the form correctly.</p>
        </section>


        <ul class="p-1">
            <task-list  v-for="(task,index) in tasks" :task="task" :key="index">
            </task-list>
        </ul>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    import TaskList from "../components/TaskList";
    import axios from 'axios'
    export default {
        name: "Home",
        data(){
            return {
                tasks: [],
                newTask: {
                    description: ''
                },
                submitStatus: null
            }
        },
        mounted() {
            axios.get('/api/tasks')
            .then(tasks => {
                console.log(tasks.data)
                this.tasks = tasks.data

            })
        },components : {
            TaskList
        },

        methods: {
            createTask() {
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                }
                else {
                    console.log(this.newTask)
                    axios.post('/api/tasks', this.newTask)
                        .then((response) => {
                            console.log(response);
                            this.tasks.push(response.data)
                            this.newTask.description = ''
                            this.submitStatus = 'OK'
                            this.$v.newTask.description.$reset()
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }

            }
        },
        validations: {
            newTask: {
                description: {
                    required
                }
            },
        }
    }
</script>

<style scoped>
.hover{

}
    .hover:hover {
        background: #e7e7e7;
        cursor: pointer;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .error {
        color: red;
    }

    .form-error {
        border: red 1px solid;
    }
</style>
