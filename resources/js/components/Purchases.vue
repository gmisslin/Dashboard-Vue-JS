<template>
    <div class="purchases">
      Achats (à venir)
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
