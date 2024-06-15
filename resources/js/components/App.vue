<template>

    <div>
        <CreateComponent></CreateComponent>
    </div>
    <div>
        <ListComponent></ListComponent>
    </div>

</template>

<script>
import CreateComponent from "./CreateComponent.vue";
import ListComponent from "./ListComponent.vue";
export default {
    name: "MainComponent",
    components: {ListComponent, CreateComponent},
}
</script>

<style>


</style>
