
export function showAlert(data) {
    toggleLoading();
    Swal.fire({
        icon: data.success ? "success" : "error",
        toast: true,
        text: data.message,
        position: "bottom-end",
        showConfirmButton: false,
        showCloseButton: true,
        timer: 3000,
    });
}

export function toggleLoading() {
    Alpine.store("loading", !Alpine.store("loading"));
}
