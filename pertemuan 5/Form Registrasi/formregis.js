const namaList = [
    "Andi Pratama", "Budi Santoso", "Citra Dewi", "Dewi Lestari",
    "Eko Nugroho", "Farhan Akbar", "Gita Rahma", "Hendra Wijaya",
    "Indah Puspita", "Joko Susilo", "Kurniawan Putra", "Lestari Ayu",
    "Muhammad Fadli", "Nur Aisyah", "Oktaviani Putri", "Putra Adi",
    "Rizky Kurniawan", "Siti Aminah", "Taufik Hidayat"
];

const namaInput = document.getElementById("nama");
const suggestionBox = document.getElementById("suggestions");

namaInput.addEventListener("input", function(){
    const query = this.value.toLowerCase();
    suggestionBox.innerHTML = "";
    if(!query){
        suggestionBox.style.display = "none";
        return;
    }
    const filtered = namaList.filter(n => n.toLowerCase().includes(query));
    if(!filtered.length){
        suggestionBox.style.display = "none";
        return;
    }
    filtered.forEach(nama => {
        const div = document.createElement("div");
        div.textContent = nama;
        div.onclick = () => {
            namaInput.value = nama;
            suggestionBox.style.display = "none";
        };
        suggestionBox.appendChild(div);
    });
    suggestionBox.style.display = "block";
});

// Popup
function showPopup(message, type){
    const popup = document.getElementById("popup");
    const popupMessage = document.getElementById("popup-message");
    const popupIcon = document.getElementById("popup-icon");

    popupMessage.innerText = message;
    popup.style.display = "flex";

    if(type === "success"){
        popupIcon.innerHTML = "✅";
        popupIcon.className = "popup-icon success";
    } else {
        popupIcon.innerHTML = "❌";
        popupIcon.className = "popup-icon error";
    }
}

function closePopup(){
    document.getElementById("popup").style.display = "none";
}

// Validasi form
document.getElementById("regForm").addEventListener("submit", function(e){
    e.preventDefault();
    const nama = namaInput.value.trim();
    const nim = document.getElementById("nim").value.trim();
    const matkul = document.getElementById("matkul").value.trim();
    const dosen = document.getElementById("dosen").value.trim();

    if(!nama || !nim || !matkul || !dosen){
        showPopup("Semua field harus diisi!", "error");
        return;
    }

    showPopup("Registrasi berhasil!", "success");
});
