import Vue from "vue";
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
export default class StorageManager extends Vue {
    loader: object;
    dropzoneOptions: object;
    dropzoneEnabled: boolean;
    beforeMount(): void;
    readonly directories: any;
    readonly files: any;
    readonly selected: any;
    readonly isLoading: any;
    readonly allSelected: any;
    readonly routes: any;
    readonly prevRoute: any;
    readonly currentRoute: any;
    readonly paths: any;
    isSelected(file: object): any;
    closeUploadModal(): void;
    onDropzoneSend(file: any, xhr: any, formData: FormData): void;
    onDropzoneSuccess(file: string): void;
}
