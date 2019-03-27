<template>
    <div class="purchases">
      Purchases
    </div>
</template>

<script>
    export default {
      data() {
        return {
          activeIndex: '1',
        };
      },
      methods: {
        handleOpen(key, keyPath) {
          console.log(key, keyPath);
        },
        handleClose(key, keyPath) {
          console.log(key, keyPath);
        }
      }
    }
</script>
