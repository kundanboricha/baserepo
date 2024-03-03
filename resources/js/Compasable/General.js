import { router } from "@inertiajs/vue3";
import { inject } from "vue";

export function useGeneral() {
    const swal = inject('$swal');

    const asset = (path) => {
        const base_path = window._asset || '';
        return base_path + path;
    };

    const baseUrl = (path) => {
        const base_path = window._BASE_URL || '';
        return base_path + path;
    };

    const preventLeadingSpace = (e) => {
        if (!e.target.value) e.preventDefault();
        else if (e.target.value[0] === ' ') {
            e.target.value = e.target.value.replace(/^\s*/, '');
        }
    };

    const preventNumericInput = ($event) => {
        const keyCode = $event.keyCode ? $event.keyCode : $event.which;
        if (keyCode > 47 && keyCode < 58) {
            $event.preventDefault();
        }
    };

    const formatDate = (date) => {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    };

    const formatDateTime = (date) => {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        let hour = '' + d.getHours();
        let minut = '' + d.getMinutes();
        let second = '' + d.getSeconds();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        if (hour.length < 2) hour = '0' + hour;
        if (minut.length < 2) minut = '0' + minut;
        if (second.length < 2) second = '0' + second;

        const dateText = [day, month, year].join('-');
        const timeText = [hour, minut, second].join(':');
        return dateText + ' ' + timeText;
    };

    const preventCharacterInput = ($event) => {
        if (!$event.key.match(/[0-9]/g)) {
            $event.preventDefault();
        }
    };

    const convertToSlug = (text) => {
        return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    };

    const confirmDelete = (route) => {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7367f0',
            cancelButtonColor: '#ea5455',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                router.get(route);
            }
        });

    };

    const resolveImageURL = (image, defaultPath = "custom_assets/profiles/", imagePath = "storage/profiles/") => {
        const isDefaultImage = image === null || /default\.(png|jpg)$/.test(image);
        return asset(isDefaultImage ? defaultPath + image : imagePath + image);
    }



    return {
        asset,
        baseUrl,
        preventLeadingSpace,
        preventNumericInput,
        formatDate,
        formatDateTime,
        preventCharacterInput,
        convertToSlug,
        confirmDelete,
        resolveImageURL,
    };
}
