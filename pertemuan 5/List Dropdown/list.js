const produkData = {
  "Smartphone": {
    "Samsung": ["Galaxy S24 Ultra", "Galaxy A55", "Galaxy Z Fold6"],
    "iPhone": ["IPhone 15 Pro Max", "IPhone 15", "IPhone XR"],
    "Xiaomi": ["Mi 14 Ultra", "Redmi Note 13"]
  },
  "Laptop": {
    "ASUS": ["ROG Zephyrus G16", "VivoBook 15", "ZenBook Pro 15"],
    "MacBook": ["MacBook Pro M3 Max", "MacBook Air M2"],
    "Lenovo": ["ThinkPad X1 Carbon", "IdeaPad Gaming 3"]
  },
  "Tablet": {
    "iPad": ["iPad Pro M4", "iPad Air"],
    "Samsung": ["Galaxy Tab S9 Ultra", "Galaxy Tab A9+"]
  }
};

const kategoriSelect = document.getElementById("kategori");
const merekSelect = document.getElementById("merek");
const produkSelect = document.getElementById("produk");
const merekGroup = document.getElementById("merekGroup");
const produkGroup = document.getElementById("produkGroup");

Object.keys(produkData).forEach(kategori => {
  const option = document.createElement("option");
  option.value = kategori;
  option.textContent = kategori;
  kategoriSelect.appendChild(option);
});

kategoriSelect.addEventListener("change", () => {
  const kategori = kategoriSelect.value;
  merekSelect.innerHTML = '<option value="">-- Pilih Merek --</option>';
  produkSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
  produkGroup.style.display = "none";

  if (kategori) {
    merekGroup.style.display = "block";
    Object.keys(produkData[kategori]).forEach(merek => {
      const option = document.createElement("option");
      option.value = merek;
      option.textContent = merek;
      merekSelect.appendChild(option);
    });
  } else {
    merekGroup.style.display = "none";
  }
});

merekSelect.addEventListener("change", () => {
  const kategori = kategoriSelect.value;
  const merek = merekSelect.value;
  produkSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';

  if (merek) {
    produkGroup.style.display = "block";
    produkData[kategori][merek].forEach(produk => {
      const option = document.createElement("option");
      option.value = produk;
      option.textContent = produk;
      produkSelect.appendChild(option);
    });
  } else {
    produkGroup.style.display = "none";
  }
});
