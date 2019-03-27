<template>
    <div class="sideBar">
      <el-menu
        default-active="2"
        class="el-menu-vertical-demo"
        @open="handleOpen"
        @close="handleClose"
        :router='true'>
          <el-menu-item index="/jobs">
            <i class="el-icon-location"></i>
            <span>Jobs</span>
          </el-menu-item>

          <el-menu-item index="/flats">
            <i class="el-icon-menu"></i>
            <span>Appartements</span>
          </el-menu-item>
          <el-menu-item index="/purchases">
            <i class="el-icon-document"></i>
            <span>Achats</span>
          </el-menu-item>

          <el-menu-item index="/foodshopping">
            <i class="el-icon-document"></i>
            <span>Courses</span>
          </el-menu-item>

      </el-menu>
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
