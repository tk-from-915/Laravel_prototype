<template>
  <CommonPageLayout title="私たちについて">
    <!-- TODO: GraphQL からデータを取得して動的に表示する -->
    <section class="about-section">
      <h5 class="about-heading">私たちのミッション</h5>
      <p>植物のある暮らしを当たり前に。私たちは、癒しと安らぎをもたらす植物を通じて、人々の暮らしをより豊かに彩るライフスタイルを創造します。</p>
    </section>
    <section class="about-section">
      <h5 class="about-heading">私たちの理念</h5>
      <p>私たちは、植物を「商品」ではなく「共に育む存在」と考えています。自然への敬意を大切にし、一つひとつに真心を込めてお客様へお届けします。</p>
    </section>
  </CommonPageLayout>
</template>

<style scoped>
.about-section {
  margin-bottom: 60px;
}
.about-heading {
  color: #007575;
  margin-bottom: 16px;
}
</style>
