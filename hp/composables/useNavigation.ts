export const useNavigation = () => {
  const isNavOpen = ref(false)

  const toggleNav = () => {
    isNavOpen.value = !isNavOpen.value
  }

  const closeNav = () => {
    isNavOpen.value = false
  }

  return { isNavOpen, toggleNav, closeNav }
}
