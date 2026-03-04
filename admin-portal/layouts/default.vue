<template>
  <div class="admin-layout">
    <CommonAdminSidebar />
    <div class="admin-right">
      <CommonAdminHeader />
      <main class="admin-main">
        <slot />
      </main>
    </div>
  </div>
</template>

<style lang="scss">
.admin-layout {
  display: flex;
  min-height: 100vh;
}

.admin-right {
  flex: 1;
  margin-left: $sidebar-width;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.admin-main {
  flex: 1;
  padding: 32px;
  background-color: $body-bg;
}
</style>
