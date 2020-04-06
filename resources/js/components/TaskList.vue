<template>
    <li class="card mb-2 p-2 hover" @click="$router.push({ name: 'task', params: {id: task.id } })">
        {{task.description}}
    </li>
</template>

<script>
    export default {
        name: 'TaskList',
        props: {
            task : Object
        }
    }
</script>
