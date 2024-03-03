import { reactive } from "vue";

export function useSelectOptions() {

    const roleOptions = reactive({
        1: "Admin",
        2: "User",
    });

    const statusOptions = reactive({
        1: "Active",
        2: "Inactive",
    });

    return {
        roleOptions,
        statusOptions,
    };
}