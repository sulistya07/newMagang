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

// ======= Ambil data berdasarkan ID ========
async function getEkskulById(id) {
    const query = `
        query {
            ekstrakurikuler(id_ekskul: ${id}) {
                id_ekskul
                nama_ekskul
                pembina
                jadwal
                kuota
            }
        }
    `;
    const res = await fetch("/graphql", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ query })
    });
    const result = await res.json();
    return result.data.ekstrakurikuler;
}

// Ambil ID dari URL
const urlParams = new URLSearchParams(window.location.search);
const ekskulId = urlParams.get("id");

// load data ke form
getEkskulById(ekskulId).then(data => {
    document.getElementById("id_ekskul").value = data.id_ekskul;
    document.getElementById("nama_ekskul").value = data.nama_ekskul;
    document.getElementById("pembina").value = data.pembina;
    document.getElementById("jadwal").value = data.jadwal;
    document.getElementById("kuota").value = data.kuota;
});

// ======== Submit update =======
document.getElementById("editEkskulForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const mutation = `
        mutation($input: UpdateEkstrakurikulerInput!) {
            updateEkstrakurikuler(input: $input) {
                id_ekskul
                nama_ekskul
                pembina
                jadwal
                kuota
                updated_at
            }  
        }
    `;
    const variables = {
        input: {
            id_ekskul: parseInt(document.getElementById("id_ekskul").value),
            nama_ekskul: document.getElementById("nama_ekskul").value,
            pembina: document.getElementById("pembina").value,
            jadwal: document.getElementById("jadwal").value,
            kuota: parseInt(document.getElementById("kuota").value)
        }
    };

    try {
        const res = await fetch("/graphql", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ query: mutation, variables })
        });

        const result = await res.json();

        if (result.errors) {
            console.error("GraphQl Error:", result.errors);
            showNotification("Gagal update data!", "error");
            return;
        }

        if (result.data?.updateEkstrakurikuler) {
            (showNotification("Data berhasil diperbarui!", "success"));
            setTimeout(() => {
                window.location.href = "/ekstrakurikuler/index";
            }, 1500)
        }

    } catch (err) {
        console.error("Request Error:", err);
        showNotification("Terjadi kesalahan server!", "error");
    }
});