// =========== Notifikasi ========
function showNotification(message, type = "success") {
    const notif = document.getElementById("notification");

    notif.textContent = message;
    notif.className = "fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg font-semibold transition-opacity";

    if (type === "success") {
        notif.classList.add("bg-green-500", "text-white");
    } else {
        notif.classList.add("bg-red-500", "text-white");
    }
        notif.classList.remove("hidden");

    // auto hilang
    setTimeout(() => {
        notif.classList.add("opacity-0"); 
        setTimeout(() => {
            notif.classList.add("hidden");
            notif.classList.remove("opacity-0");
        }, 500);
    }, 3000);
}

// ========== TAMBAH DATA =============
document.getElementById("createForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const input = {
        nama_ekskul: formData.get("nama_ekskul"),
        pembina: formData.get("pembina"),
        jadwal: formData.get("jadwal"),
        kuota: formData.get("kuota") ? parseInt(formData.get("kuota")) : null,
    };
    const query = `
        mutation($input: CreateEkstrakurikulerInput!) {
            createEkstrakurikuler(input: $input) {
                id_ekskul
                nama_ekskul
            }
        }
    `;

    try {
        const response = await fetch("/graphql", {
            method: "POST",
            header: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ query, variables: { input } }),
        });

        const result = await response.json();
        if (result.errors) {
            console.error("GraphQL Error:", result.errors);
            showNotification("Gagal menyimpan data!", "error");
            return;
        }
        if (result.data?.createEkstrakurikuler) {
            showNotification("Data berhasil ditambah!", "success");

            setTimeout(() => {
                window.location.href = "/ekstrakurikuler"; // redirect ke index
            }, 1500);
        }
    } catch (err) {
        console.error("Request error:", err);
        showNotification("Terjadi kesalahan server!", "error");
    }
});