<template>
  <CommonPageLayout title="会社情報">
    <!-- TODO: GraphQL からデータを取得して動的に表示する -->
    <table class="company-table">
      <tbody>
        <tr>
          <th>会社名</th>
          <td>株式会社Little Healing Green</td>
        </tr>
        <tr>
          <th>代表取締役</th>
          <td>〇〇 〇〇</td>
        </tr>
        <tr>
          <th>設立</th>
          <td>20〇〇年〇月</td>
        </tr>
        <tr>
          <th>資本金</th>
          <td>〇〇〇万円</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>〒012-3456-7890 東京都〇〇区△△△3丁目11-22</td>
        </tr>
        <tr>
          <th>TEL</th>
          <td>03-0000-0000</td>
        </tr>
        <tr>
          <th>事業内容</th>
          <td>観葉植物・多肉植物・テラリウムの販売</td>
        </tr>
      </tbody>
    </table>
  </CommonPageLayout>
</template>

<style scoped>
.company-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 18px;
}
.company-table th,
.company-table td {
  padding: 16px 20px;
  border-bottom: 1px solid #e0e0e0;
  text-align: left;
  vertical-align: top;
}
.company-table th {
  width: 30%;
  color: #007575;
  font-weight: normal;
  white-space: nowrap;
}
</style>
