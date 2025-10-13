let lastPage = 1;
let currentPage = 1;
let perPage = 10;
let isSearching = false;
let lastSearchTerm = "";

// ===== Notifikasi =====
function showNotification(message, type = "success") {
    const notif = document.getElementById("notification");
    // reset class
    notif.className =
        "fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg font-semibold transition-opacity hidden";
    //isi pesan
    notif.textContent = message;
    // Tambahkan warna sesuai type
    if (type === "success") {
        notif.classList.add("bg-green-500", "text-white");
    } else if (type === "error") {
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
async function loadEkstrakurikuler(page = 1) {
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
                hasMorePages
                total
            }
        }
    } 
    `;

    try {
        const response = await fetch("/graphql", {
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
async function searchEkstrakurikuler() {
    const keyword = document.getElementById("searchInput").value.trim();
    if (keyword === "") {
        loadEkstrakurikuler(1);
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
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body: JSON.stringify({ query })
        });
        const result = await response.json();
        if (result.errors) throw result.errors;
        renderTable(result.data.ekstrakurikulerByNama || []);
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
    if (!items || items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4">Belum Ada Data</td></tr>`;
        return;
    }
    items.forEach((item) => {
        tbody.innerHTML += `
        <tr>
            <td class="border px-4 py-2">${item.id_ekskul}</td>
            <td class="border px-4 py-2">${item.nama_ekskul}</td>
            <td class="border px-4 py-2">${item.pembina ?? '-'}</td>
            <td class="border px-4 py-2">${item.jadwal ?? '-'}</td>
            <td class="border px-4 py-2">${item.kuota ?? '-'}</td>
            <td class="border px-4 py-2 space-x-2">
            <a href="/ekstrakurikuler/edit?id=${item.id_ekskul}" class="text-blue-600 hover:underline">Edit</a>
            <button onclick="openDeleteModal(${item.id_ekskul}, '${item.nama_ekskul}')" class="text-red-600 hover:underline">Hapus</button>
            </td> 
        </tr>
        `;
    });

}

// ============ RENDER PAGINATION =============
function renderPagination(info) {
    currentPage = info.currentPage;
    lastPage = info.lastPage;
    const pagination = document.getElementById("pagination");
    let pageOptions = "";
    for (let i = 1; i <= lastPage; i++) {
        pageOptions += `<option value="${i}" ${i === currentPage ? "selected" : ""}>Halaman ${i}</option>`;
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
        <button ${currentPage <= 1 ? "disabled" : ""}
            onclick="loadEkstrakurikuler(${currentPage - 1})"
            class="px-3 py-1 border rounded ${currentPage <= 1 ? 'bg-gray-200 text-gray-400' : 'bg-white hover:bg-gray-100'}">
            ← Prev
        </button>

        <select onchange="loadEkstrakurikuler(this.value)" class="border px-2 py-1 rounded">
            ${pageOptions}
        </select>

            <button ${currentPage >= lastPage ? "disabled" : ""}
                onclick="loadEkstrakurikuler(${currentPage + 1})"
                class="px-3 py-1 border rounded ${currentPage >= lastPage ? 'bg-gray-200 text-gray-400' : 'bg-white hover:bg-gray-100'}">
            </button>
        </div>
    `;
}

function changePerPage(value) {
    perPage = parseInt(value);
    loadEkstrakurikuler(1);
}

// =========== DELETE DATA ===========
let deleteId = null;
// buka modal konfirmasi
function openDeleteModal(id, nama) {
    deleteId = id;
    document.getElementById("deleteMessage").textContent =
        `Apakah Anda yakin ingin menghapus "${nama}"?`;
    document.getElementById("deleteModal").classList.remove("hidden");
}

// tutup modal
function closeDeleteModal() {
    deleteId = null;
    document.getElementById("deleteModal").classList.add("hidden");
}

// hapus data
async function confirmDeleteEkstrakurikuler() {
    if (!deleteId) return;

    try {
        const mutation = `
            mutation {
                deleteEkstrakurikuler(id_ekskul: ${deleteId}) {
                    id_ekskul
                    nama_ekskul
                    deleted_at
                }
            }
        `;
        const response = await fetch("/graphql", {
            method: "POST",
            headers: {
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
        showNotification("Data berhasil dihapus", "success");
        closeDeleteModal();

        if (isSearching && lastSearchTerm) {
            searchEkstrakurikuler();
        } else {
            loadEkstrakurikuler(currentPage);
        }
    } catch (err) {
        console.error("deleteEkstrakurikuler error", err);
        showNotification("Terjadi kesalahan saat menghapus!", "error");
        closeDeleteModal();
    }
}

// event klik tombol "Ya, Hapus"
document.getElementById("confirmDeleteBtn").addEventListener("click", confirmDeleteEkstrakurikuler);

// ============== EVENT LISTENER ================
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("clearSearchBtn").addEventListener("click", () => {
        document.getElementById("searchInput").value = "";
        loadEkstrakurikuler(1);
    });

    let searchTimeout = null;
    document.getElementById("searchInput").addEventListener("input", (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const keyword = e.target.value.trim();
            if (keyword === "") {
                loadEkstrakurikuler(1);
            } else {
                searchEkstrakurikuler();
            }
        }, 300); //delay 300ms
    });

    // initial load
    loadEkstrakurikuler();
});