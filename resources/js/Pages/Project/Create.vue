<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';


defineProps({
  errors: Object,
  skills: Array,
});


const form = useForm({
  name:'',
  image: null,
  skill_id:'',
  project_url:'',
})

const submit = () => {
  form.post(route('project.store'));
}



</script>

<template>

  <Head title="project-create" />
  <h2 class="text-xl text-white bg-slate-700 leading-tight text-center ">Project Create Page</h2>

  <div class="w-full mt-5 pb-5 ">
    <Link :href="route('project.index')" type="button"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    Project Page</Link>
  </div>

  <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
    <div>
      <form @submit.prevent="submit" class="max-w-lg mx-auto" action="">
        <!-- Name -->
        <div class="mb-5">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project Name</label>
          <input type="text" id="name" v-model="form.name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "
            placeholder="Write Project Name">
          <div class="text-red-400 text-sm " v-if="errors && errors.name">{{ errors.name }}</div>


          <!-- Skill -->
          <div class="mb-5">
            <label for="skill" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Skill Name</label>
            <select v-model="form.skill_id" id="skill_id" name="skill_id"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-red-400 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md ">
              <option v-for="skill in skills" :key="skill.id" :value="skill.id">{{ skill.name }}</option>
            </select>
          </div>


          <!--  url -->
          <div class="mb-5">
            <label for="project_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
              Url</label>
            <input type="text" id="project_url" v-model="form.project_url"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Write Project url" />
            <div class="text-red-400 text-sm" v-if="errors && errors.project_url">{{ errors.project_url }}</div>
          </div>


          <!-- image -->

          <div class="mb-5">
            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image Upload</label>
            <input type="file" id="image" @input="form.image = $event.target.files[0]"
              class="bg-white-50 border border-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

            <div class="text-red-400 text-sm" v-if="errors && errors.image">{{ errors.image }}</div>
          </div>

          <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Submit
          </button>




        </div>
      </form>
    </div>
  </div>

</template>

<style></style>