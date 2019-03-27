<template>
    <div class="header">
      <el-menu :default-active="activeIndex" class="el-menu-demo" :router="true" mode="horizontal" @select="handleSelect">
        <el-menu-item index="/">Administration Geoffrey</el-menu-item>
        <!-- <el-submenu index="2">
          <template slot="title">Lieu de travail</template>
          <el-menu-item index="2-1">item un</el-menu-item>
          <el-menu-item index="2-2">item deux</el-menu-item>
          <el-menu-item index="2-3">item trois</el-menu-item>
          <el-submenu index="2-4">
            <template slot="title">item quatre</template>
            <el-menu-item index="2-4-1">item un</el-menu-item>
            <el-menu-item index="2-4-2">item deux</el-menu-item>
            <el-menu-item index="2-4-3">item trois</el-menu-item>
          </el-submenu>
        </el-submenu>
        <el-menu-item index="3" disabled>Infos</el-menu-item>
        <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">Commandes</a></el-menu-item> -->
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
        handleSelect(key, keyPath) {
          console.log(key, keyPath);
        }
      }
    }
</script>
