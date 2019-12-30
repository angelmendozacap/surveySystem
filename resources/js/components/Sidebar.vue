<template>
  <nav v-if="authUser" class="py-4">

    <div v-if="isCreator" class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">Creador</h5>

      <ul>
        <li>
          <router-link :to="{name: 'createSurvey'}" class="link">
            <span class="tracking-wide">Crear Encuesta</span>
          </router-link>
        </li>

        <li>
          <router-link :to="{name: 'surveyList'}" class="link">
            <span class="tracking-wide">Lista de Encuestas</span>
          </router-link>
        </li>
      </ul>
    </div>

    <div v-if="isStudent" class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">Estudiante</h5>

      <ul>
        <li>
          <router-link to="/contacts" class="link">
            <span class="tracking-wide">Encuestas</span>
          </router-link>
        </li>
      </ul>

    </div>

    <div class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">Configuraciones</h5>

      <ul>
        <li>
          <a href="#" @click.prevent="logout" class="link link--red">
            <span class="tracking-wide">Logout</span>
          </a>
        </li>
      </ul>
    </div>

  </nav>
</template>

<script>

import { mapGetters } from 'vuex'

import { Roles } from '../helpers/roles'

export default {
  name: 'Sidebar',
  methods: {
    async logout() {
      try {
        await axios.post('/logout', {})
      } catch (err) {
        if (err.response.status === 401) {
          window.location = '/login'
        }
      }
    }
  },
  computed: {
    ...mapGetters('User', [
      'authUser'
    ]),

    isAdmin() {
      return this.authUser.data.role.data.name === Roles.Admin
    },

    isCreator() {
      return this.authUser.data.role.data.name === Roles.Creator || this.isAdmin
    },

    isStudent() {
      return this.authUser.data.role.data.name === Roles.Student || this.isAdmin
    }
  }
}
</script>

<style lang="scss" scoped>
  .link {
    @apply text-sm py-1 px-2 -mx-2 block font-medium;
    transition: all .2s ease;

    &:hover {
      @apply text-blue-600;
      transform: translateX(2px);
    }

    &.router-link-exact-active.router-link-active {
      @apply text-blue-600;
    }

    &.link--red {
      @apply text-red-700;
    }

    &.link--red:hover {
      @apply text-red-800;
    }
  }
</style>
