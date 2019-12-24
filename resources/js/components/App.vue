<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
    <Header />
    <div class="flex overflow-y-hidden flex-1">
      <aside class="overflow-x-hidden bg-white border-gray-400 p-4 border-r w-1/4">
        <Sidebar />
      </aside>

      <main class="overflow-x-hidden w-3/4">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
import Header from './Header'
import Sidebar from './Sidebar'


export default {
  name: 'App',
  components: {
    Header,
    Sidebar
  }
}
</script>
