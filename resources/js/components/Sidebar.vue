<template>
  <nav class="py-4">
    <div class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">Creador</h5>

      <ul>
        <li>
          <router-link :to="{name: 'home'}" class="link">
            <span class="tracking-wide">Crear Encuesta</span>
          </router-link>
        </li>
      </ul>
    </div>

    <div class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">General</h5>

      <ul>
        <li>
          <router-link to="/contacts" class="link">
            <span class="tracking-wide">Contactos</span>
          </router-link>
        </li>

        <li>
          <router-link to="/birthdays" class="link">
            <span class="tracking-wide">Cumpleaños</span>
          </router-link>
        </li>
      </ul>

    </div>

    <div class="mb-8">
      <h5 class="text-gray-500 text-xs uppercase font-bold">Configuraciones</h5>

      <ul>
        <li>
          <a href="#" class="link link--red">
            <span class="tracking-wide">Logout</span>
          </a>
        </li>
      </ul>
    </div>

  </nav>
</template>

<script>
export default {
  name: 'Sidebar'
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
