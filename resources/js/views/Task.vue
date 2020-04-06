<template>
    <div class="Hello">
        <div class="alert alert-dismissible fade "
             :class="{'alert-success': success.state, 'alert-danger' : fail.state, 'show': success.state || fail.state }"
             role="alert">
            <span v-if="success.state" v-html="success.msg"></span>
            <span v-if="fail.state" v-html="fail.msg"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <h1 v-if="error"> {{noTask}}</h1>
        <div v-if="!error" class="card mb-2">
            <section class="card-header d-flex justify-content-around align-items-center"><h2>tache n°{{task.id}}</h2>
                <i class="far fa-edit pointer" @click="edit = !edit"></i></section>
            <section class="card-body d-flex flex-column" :class="{ 'form-group--error': $v.updatedTask.description.$error }">
                <span v-if="!edit">{{updatedTask.description}}</span>

                <input class="form-control" :class="{'form-error': ($v.updatedTask.description.$error) || (submitStatus === 'ERROR' && updatedTask.description === '')}" v-else type="text" width="90%" v-model.trim="$v.updatedTask.description.$model" @keypress.enter="editTask">
                <span class="error" v-if="$v.updatedTask.description.$error">Field is required</span>
                <p class="typo__p error" v-if="submitStatus === 'ERROR' && updatedTask.description === ''">Please fill the form correctly.</p>
            </section>
        </div>

        <span v-if="!error" class="text-danger pointer del" @click="deleteTask">supprimer cette tache.</span>

    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'
    import axios from "axios";

    export default {
        name: "Task",
        data() {
            return {
                task: {},
                updatedTask: {
                    description: ''
                },
                error: false,
                noTask: "cette tache n'existe pas !",
                edit: false,
                success:
                    {
                    state: false,
                    msg: `<strong>Yay!</strong> Cette tâche a bien été supprimé !`
                    },
                fail:
                    {
                    state: false,
                    msg: `<strong>Oops!</strong> quelque chose a raté !`
                    },
                submitStatus: null
            }
        },
        props: {
            id: Number
        },
        mounted() {
            axios.get('/api/tasks/' + this.id)
                .then(task => {
                    console.log(task.data)
                    this.task = task.data
                    this.updatedTask.description = this.task.description
                })
                .catch(err => {
                    this.error = !this.error
                })
        },

        methods: {
            editTask() {
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                } else {
                    axios.put('api/tasks/' + this.id, this.updatedTask)
                        .then((response) => {
                            this.submitStatus = 'OK'
                            this.$v.updatedTask.description.$reset()
                            this.edit = !this.edit
                            console.log(response);
                        })
                        .catch((error) => {
                            this.fail.state = true
                            console.log(error);
                        });
                }

            },

            deleteTask() {
                axios.delete('api/tasks/' + this.id)
                    .then((response) => {
                        if (response.status === 204) {
                            this.success.state = true
                            setTimeout(() => {
                                this.$router.push({name: 'home'})
                            }, 3000)
                        }
                        console.log(response);
                    })
                    .catch((error) => {
                        this.success.state = false
                        this.fail.state = true

                    });
            }
        },
        validations: {
            updatedTask: {
                description: {
                    required
                }
            },
        }
    }
</script>

<style scoped>
    .pointer {
        cursor: pointer;
        transition: 0.5s;
    }

    .pointer:hover {
        color: #1f6fb2;

        transform: scale(1.2);
    }

    .del:hover {
        text-decoration: underline;
    }

    .display {
        display: none;
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
