<template>
  <div class="box-shade" :class="{hideBox : hideBox }">
    <span>
      等待加载
      <i>。。。</i>
    </span>
  </div>
</template>

<script>
export default {
  name: "boxShade",
  props: {
    hide: { type: Boolean, default: true }
  },
  computed: {},
  methods: {},
  data: function() {
    return {
      hideBox: this.hide
    };
  },
  watch: {
    hide: function(val) {
      this.hideBox = val;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.box-shade {
  width: 100%;
  height: 100%;
  background-color: rgba(94, 88, 88, 0.2);
  position: absolute;
  top:0;
  left:0;
  z-index: 1;
}

.box-shade span {
  position: absolute;
  background-color: #fff;
  height: 100px;
  width: 200px;
  line-height: 100px;
  top: 50%;
  left: 50%;
  text-align: center;
  transform: translate(-50%, -50%);
}

.box-shade span i {
  animation: myfirst 2s linear infinite alternate;
  display: inline-block;
}

.hideBox {
  display: none;
}

@keyframes myfirst {
  0% {
    transform: translate(0);
  }

  50% {
    transform: translate(50%);
  }

  100% {
    transform: translate(100%);
  }
}
</style>
