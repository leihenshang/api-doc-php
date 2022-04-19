<template>
  <svg class="icon">
    <use :xlink:href="`#icon-${iconName}`"></use>
  </svg>
</template>

<script lang="ts">
export default {
  name: 'SvgIcon',
  props:{
    iconName:{type:String}
  }
}
</script>
