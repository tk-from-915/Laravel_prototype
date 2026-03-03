<template>
  <AuthPageWrapper title="Sign up" action-label="Login" action-to="/login">
    <h2 class="auth-title">Create your Account</h2>

    <form class="auth-card" @submit.prevent="handleSignup">
      <div class="auth-field">
        <label class="auth-field__label">user_name</label>
        <input v-model="form.name" type="text" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">mail_adress</label>
        <input v-model="form.email" type="email" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">password</label>
        <input v-model="form.password" type="password" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">confirm password</label>
        <input v-model="form.confirmPassword" type="password" class="auth-field__input" required />
      </div>

      <button type="submit" class="auth-btn">Sign up</button>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })

const form = reactive({ name: '', email: '', password: '', confirmPassword: '' })

function handleSignup() {
  // TODO: GraphQL mutation でユーザー登録処理を実装
  navigateTo('/')
}
</script>

<style lang="scss" scoped>
.auth-title {
  font-size: 26px;
  font-weight: bold;
  color: $primary;
  margin-bottom: 20px;
  text-align: center;
}

.auth-card {
  width: 400px;
  background-color: #efefef;
  padding: 32px 40px 36px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.auth-field {
  width: 100%;
  margin-bottom: 16px;

  &__label {
    display: block;
    font-size: 13px;
    color: $text-muted;
    margin-bottom: 6px;
    text-align: center;
  }

  &__input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    font-size: 15px;
    box-sizing: border-box;

    &:focus {
      outline: none;
      border-color: $primary;
    }
  }
}

.auth-btn {
  width: 200px;
  padding: 10px;
  margin-top: 24px;
  background-color: rgba($primary, 0.5);
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background-color 0.15s;

  &:hover {
    background-color: rgba($primary, 0.65);
  }
}
</style>
