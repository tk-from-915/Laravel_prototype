<template>
  <div class="dashboard">
    <!-- TODO: GraphQL から各セクションの最新活動ログを取得して表示する -->
    <div v-for="section in sections" :key="section.key" class="activity-section">
      <h2 class="activity-section__title">{{ section.title }}</h2>
      <div class="activity-card">
        <div class="activity-card__inner">
          <p v-for="(item, i) in section.items" :key="i" class="activity-item">
            {{ item }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const sections = [
  {
    key: 'menu',
    title: '最新Menu情報',
    items: [
      '2020/05/11  テストユーザ１さんによって モンステラ が更新されました。',
      '2020/07/18  tokiさんによって 多肉植物 が更新されました。',
      '2020/10/21  テストユーザ３さんによって テラリウム が更新されました。',
    ],
  },
  {
    key: 'news',
    title: '最新News情報',
    items: [
      '2020/05/11  テストユーザ１さんによって モンステラ が更新されました。',
      '2020/07/18  tokiさんによって 多肉植物 が更新されました。',
      '2020/10/21  tokiさんによって テラリウム が更新されました。',
    ],
  },
  {
    key: 'blog',
    title: '最新Blog情報',
    items: [
      '2020/05/11  テストユーザ１さんによって モンステラ が更新されました。',
      '2020/07/18  tokiさんによって 多肉植物 が更新されました。',
      '2020/10/21  tokiさんによって テラリウム が更新されました。',
    ],
  },
  {
    key: 'contact',
    title: '最新お問い合わせ情報',
    items: [
      '2020/05/11  〇〇さんによって 店舗へのお問い合わせを頂きました。',
      '2020/07/18  〇〇さんによって 採用情報のお問い合わせを頂きました。',
      '2020/10/21  〇〇さんによって 採用情報へのお問い合わせを頂きました。',
    ],
  },
]
</script>

<style lang="scss" scoped>
.dashboard {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.activity-section {
  &__title {
    font-size: 24px;
    color: $primary;
    margin-bottom: 12px;
    font-weight: normal;
  }
}

.activity-card {
  background: rgba($primary, 0.4);
  border: 1px solid #fff;
  padding: 8px;

  &__inner {
    background: #fff;
    border: 1px solid rgba($primary, 0.4);
    padding: 16px 24px;
  }
}

.activity-item {
  color: $text-muted;
  font-size: 18px;
  padding: 10px 0;

  & + & {
    border-top: none;
  }
}
</style>
