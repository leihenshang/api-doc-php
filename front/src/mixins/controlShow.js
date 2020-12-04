export default {
    methods: {
        controlShow() {
            return (this.$store.state.projectPermission == 6 || this.$store.state.userInfo.type === 2);
        }
    }
}