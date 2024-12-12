<template>
  <div class="container-fluid footer-content">

    <div class="row py-3 row-block">
      <div class="col-12 col-md-5 col-xl-3 border-right ps-4 py-4">
        <div class="text py-1">User Balances App</div>
        <div class="text py-1">Test task for Excdev Team</div>
      </div>
      <div class="col-12 col-md-7 col-xl-8 ps-4 py-3">
        <div class="text py-1">My contact:</div>
        <div class="text py-1"><a href="https://t.me/alex_dev_256" target="_blank"><u>https://t.me/alex_dev_256</u></a></div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

.footer-content {
  background-color: black;
  position: relative;
}

.footer-content::after {
  content: '';
  display: block;
  background-color: black;
  height: 100px;
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  z-index: -1;
}

.border-right {
  border-right: 1px solid white !important;
}

.text {
  font-family: $primary-font;
  font-weight: 400;
  font-size: 14px;

  color: white;
}

a {
  color: white;
}

</style>
