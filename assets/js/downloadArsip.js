document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll("[data-unduh]");

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            const fileUrl = btn.getAttribute("data-file");

            const link = document.createElement("a");
            link.href = fileUrl;
            link.download = fileUrl.split("/").pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
});
