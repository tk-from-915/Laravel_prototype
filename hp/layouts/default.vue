<template>
  <div class="layout-wrapper">
    <CommonAppHeader />
    <div class="layout-content">
      <slot />
    </div>
    <CommonAppFooter />
  </div>
</template>

<style>
.layout-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.layout-content {
  flex: 1;
}
</style>
