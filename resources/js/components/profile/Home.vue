<template>
  <div class="container-fluid">
      <table>
          <thead>
              <tr v-for="user in users" :key="user.id">
                <td>{{user.id}}</td>
                <td>
                    <a :href="'profiles/'+user.id">{{user.name}}</a>
                </td>
              </tr>
          </thead>
      </table>
  </div>
</template>

<script>
export default {
    props: ['users']
}
</script>

<style>

</style>