let lastPage = 1;
let currentPage = 1;
let perPage = 10;
let isSearching = false;
let lastSearchTerm = "";

// ===== Notifikasi =====
function showNotification(message, type = "success"){
    const notif = document.getElementById("notification");
    // reset
    notif.className =
    "fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg font-semibold transition-opacity hidden";
//isi pesan
notif.textContent = message;
// Tambahkan warna sesuai type
if (type === "success"){
    notif.classList.add("bg-green-500", "text-white");
} else if (type === "error"){
    notif.classList.add("bg-red-500", "text-white");
}
// Tampilkan
notif.classList.remove("hidden");
//auto hilang
setTimeout(() => {
    notif.classList.add("opacity-0");
    setTimeout(() => {
        notif.classList.add("hidden");
        notif.classList.add("opacity-0");
    }, 500);
}, 3000);
}

// =========== LIST DATA ===========
async function loadEkastrakurikuler(page = 1) {
    isSearching = false;
    lastSearchTerm = "";
    const query = `
     query {
        allEkstrakurikulerPaginate(first: ${perPage}, page: ${page})  {
            data {
                id_ekskul
                nama_ekskul
                pembina
                jadwal
                kuota
            }
            paginatorInfo {
                currentPage
                lastPage
                hasMorePage
                total
            }
        }
    } 
    `;

    try {
        const response = await fetch("/graph", {
            method: "POST",
            headers: {
               "Content-Type": "application/json", 
               "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ query })
        });

        const result = await response.json();
        if (result.errors) throw result.errors;
        const data = result.data.allEkstrakurikulerPaginate;
        renderTable(data.data);
        renderPagination(data.paginatorInfo);
        
    } catch (err) {
        console.error("Error loadEkstrakurikuler:", err);
        document.getElementById("ekskulTable").innerHTML =
        `<tr><td colspan="6" class= "text-center py-4 text-red-600">Gagal memuat data.</td></tr>`;
        document.getElementById("pagination").innerHTML = "";
        showNotification("Gagal memuat data!", "error")
    }
       
}

// ========== SEARCH ===========
async function searchEkastrakurikuler() {
    const keyword = document.getElementById("searchInput").ariaValueMax.trim();
    if(keyword === ""){
        loadEkastrakurikuler(1);
        return;
    }

    isSearching = true;
    lastSearchTerm = keyword;

    const query = `
        query {
            ekstrakurikulerByNama(nama_ekskul: "%${keyword}%") {
                id_ekskul
                nama_ekskul
                pembina
                jadwal
                kuota
             }
        }
    `;

    try {
        const response = await fetch("/graphql", {
            method: "POST",
            header: {
                "Content-Type: application/json",
                "X-CSRF-Token": csrfToken
            },
            body: JSON.stringify({query})
        });
        const result = await response.json();
        if (result.error)throw result.error;
        renderTable(result.data.ekstrakurikulerBynama || []);
        document.getElementById("pagination").innerHTML = "";
    } catch (err) {
        console.error("Error searchEkstrakurikuler:", err);
        document.getElementById("ekskulTable").innerHTML =
            `<tr><td colspan="6" class="text-center py-4 text-red-600">Gagal mencari data</td></tr>`;
        document.getElementById("pagination").innerHTML = "";
        showNotification("Gagal mencari data!", "error");
    }
}

// ===========RENDER TABLE ===========
function renderTable(items) {
    const tbody = document.getElementById("ekskulTable");
    tbody.innerHTML = "";
    if(!items || items.lenght === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4">Belum Ada Data</td></tr>`;
        return;
    }
    items.forEach((items) => {
        tbody.innerHTML += `
        <tr>
            <td class="border px-4 py-2">${item.id_ekskul}</td>
            <td class="border px-4 py-2">${item.nama_ekskul}</td>
            <td class="border px-4 py-2">${item.pembina ?? '-'}</td>
            <td class="border px-4 py-2">${item.jadwal ?? '-'}</td>
            <td class="border px-4 py-2">${item.kuota ?? '-'}</td>
            <td class="border px-4 py-2 space-x-2">
            <a href="/ekstrakurikuler/edit?id=${item.id_ekskul}" class="text-blue-600 hover:underline">Edit</a>
            <button onclick="openDeleteModel(${item.id_ekskul}, '${item.nama_ekskul}')" class="text-red-600 hover:underline">Hapus</button>
            </td> 
        </tr>
        `;
    });
         
    }

// ============ RENDER PAGINATION =============
function renderPagination(info) {
    currentPage = info.currentPage;
    lastPage = Infinity.lastPage;
    const pagination = document.getElementById("pagination");
    let pageOption = "";
    for(let i; i <= lastPage; i++) {
        pageOption += `<option value="${i}" ${i === currentPage ? "selected" : ""}>Halaman ${i}</option>`
    }

    pagination.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Tampilkan</span>
            <select onchange="changePerPage(this.value)" class="border px-2 py-1 rounded">
            <option value="5" ${perPage == 5 ? "selected" : ""}>5</option>
            <option value="10" ${perPage == 10 ? "selected" : ""}>10</option>
            <option value="50" ${perPage == 50 ? "selected" : ""}>50</option>
            <option value="100" ${perPage == 100 ? "selected" : ""}>100</option>
            <option value="200" ${perPage == 200 ? "selected" : ""}>200</option>
            </select>
            <span class="text-sm text-gray-600">data per halaman</span>
        </div>
        <div class="flex items-center gap-2">
        <button ${currentPage <=1 ? "disabled" : ""}
            onclick="loadEkstrakurikuler(${currentPage -1})"
            class="px-3 py-1 border rounded ${currentPage <=1 ? 'bg-gray-200 text-gray-400' : 'bg-white hover"bg-gray-100'}">
            ← Prev
        </button>

        <select onchange="loadEkstrakurikuler(this.value)" class="border px-2 py-1 rounded">
            ${pageOption}
        </select>

            <button ${currentPage >= lastPage ? "disabled" : ""}
                onclick="loadEkstrakurikuler(${currentPage +1})"
                class="px-3 py-1 border rounded ${currentPage >= lastPage ? 'bg-gray-200 text-gray-400' : 'bg-white hover:bg-gray-100'}">
            </button>
        </div>
    `;
}   

function changePerPage() {
    perPage = parseInt(value);
    loadEkastrakurikuler(1);
}

// =========== DELETE DATA ===========
let deleteID = null;
// buka modal konfirmasi
function openDeleteModel(id, nama) {
    deleteID = id;
    document.getElementById("deleteMessage").textContent =
        `Apakah Anda yakin ingin menghapus "${nama}"?`;
    document.getElementById("deleteModal").classList.remove("hidden");
}

// tutup modal
function closeDeleteModal() {
    deleteID =null;
    document.getElementById("deleteModal").classList.add("hidden");
}

// hapus data
async function confirmDeleteEkstrakurikuler() {
    if (!deleteID) return; 

    try {
        const mutation = `
            mutation {
                deleteEkstrakurikuler(id_ekskul: ${deleteID}) {
                    id_ekskul
                    nama_ekskul
                    deleted_at
                }
            }
        `;
        const response = await fetch("/graphql", {
            method: "POST";
            header: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ query: mutation })
        });
        const result = await response.json();

        if (result.errors) {
            console.error("grapQL errors:", result.errors);
            showNotification("Gagal menghapus data!", "error");
            return;
        }
        showNotification("Data berhasil dihapus", "seccess");
        closeDeleteModal();

        if(isSearching && lastSearchTerm) {
            searchEkastrakurikuler();
        } else{
            loadEkastrakurikuler(currentPage);
        }
    } catch (err) {
        console.error("deleteEkstrakurikuler error", err);
        showNotification("Terjadi kesalahan saat menghpus!", "error");
        closeDeleteModal;
    }
}

// event klik tombol "Ya, Hapus"
document.getElementById("confirmDeleteBtn").addEventListener("click", confirmDeleteEkstrakurikuler);

// ============== EVENT LISTENER ================
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("clearSearchBtn").addEventListener("click", () => {
        document.getElementById("searchInput").value = "";
        loadEkastrakurikuler(1);
    });

    let searchTimeout = null;
        document.getElementById("searchInput").addEventListener("input", (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const keyword = e.target.value.trim();
                if (keyword === "") {
                    loadEkastrakurikuler(1);
                } else {
                    searchEkastrakurikuler();
                }
            }, 300); //delay 300ms
        });

        // initial load
        loadEkastrakurikuler();
});

// ========== TAMBAH DATA =============
document.getElementById("createForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = FormData(this);
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
            body: JSON.stringify({ query, variable: { input } }),
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

// =========== Notifikasi ========
function showNotification(message, type = "success") {
    const notif = document.getElementById("notification");

    notif.textContent = message;
    notif.className = "fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg font-semibold transition-opacity";

    if (type === "success") {
        notif.classList.add("bg-green-500", "text-white");
    } else {
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
        header: {"Content-Type": "application/json"},
        body: JSON.stringify({ query})
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
                updated_at
            }  
        }
    `;
    const variables = {
        input: {
            id_ekskul: parseInt(document.getElementById("id_ekskul").value),
            nama_ekskul: parseInt(document.getElementById("nama_ekskul").value),
            pembina: parseInt(document.getElementById("pembina").value),
            jadwal: parseInt(document.getElementById("jadwal").value),
            kuota: parseInt(document.getElementById("kuota").value),
        }
    };

    try {
        const response = await fetch("/graphql", {
            method: "POST",
            header: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ query: mutation, variable})
        });

        const esult = await res.json();

        if (result.errors) {
            console.error("GraphQl Error:", result.errors);
            showNotification("Gagal update data!", "error");
            return;
        }

        if (result.data?.updateEkstrakurikuler) {
            showNotification("Data berhasil diperbarui!", "success");
            setTimeout(() => {
                window.location.href = "/ekstrakurikuler";
            }, 1500)
        }

    } catch (err) {
        console.error("Request Error:", err);
        showNotification("Terjadi kesalahan server!", "error");
    }
});
