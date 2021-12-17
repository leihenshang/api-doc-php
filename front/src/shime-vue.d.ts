declare module '*.vue' {
  import { ComponentOptions} from 'vue'
  const componentOptions: ComponentOptions
  export default ComponentOptions
}
declare module "*.svg" {
  const content: string;
  export default content;
}