const data = {
  "DKI Jakarta": {
    "Jakarta Selatan": {
      "Kebayoran Baru": "12120",
      "Pasar Minggu": "12510"
    },
    "Jakarta Barat": {
      "Grogol Petamburan": "11450",
      "Cengkareng": "11730"
    }
  },
  "Jawa Barat": {
    "Bandung": {
      "Coblong": "40132",
      "Lengkong": "40261"
    },
    "Bekasi": {
      "Bekasi Timur": "17111",
      "Bekasi Barat": "17131"
    }
  },
  "Jawa Tengah": {
    "Semarang": {
      "Tembalang": "50275",
      "Pedurungan": "50192"
    },
    "Solo": {
      "Banjarsari": "57131",
      "Laweyan": "57148"
    }
  },
  "Jawa Timur": {
    "Surabaya": {
      "Wonokromo": "60243",
      "Tegalsari": "60262"
    },
    "Malang": {
      "Klojen": "65111",
      "Lowokwaru": "65141"
    }
  },
  "Bali": {
    "Denpasar": {
      "Denpasar Barat": "80119",
      "Denpasar Timur": "80237"
    },
    "Badung": {
      "Kuta": "80361",
      "Mengwi": "80351"
    }
  },
  "Sumatera Utara": {
    "Medan": {
      "Medan Tuntungan": "20136",
      "Medan Timur": "20231"
    },
    "Binjai": {
      "Binjai Kota": "20741",
      "Binjai Selatan": "20732"
    }
  },
  "Kalimantan Selatan": {
    "Banjarmasin": {
      "Banjarmasin Barat": "70111",
      "Banjarmasin Timur": "70236"
    },
    "Banjarbaru": {
      "Banjarbaru Utara": "70711",
      "Banjarbaru Selatan": "70714"
    }
  },
  "Sulawesi Selatan": {
    "Makassar": {
      "Ujung Pandang": "90111",
      "Panakkukang": "90231"
    },
    "Gowa": {
      "Somba Opu": "92111",
      "Bontomarannu": "92171"
    }
  }
};

const provinsiSelect = document.getElementById("provinsi");
const kabupatenSelect = document.getElementById("kabupaten");
const kecamatanSelect = document.getElementById("kecamatan");
const hasilDiv = document.getElementById("hasil");

Object.keys(data).forEach(prov => {
  let option = document.createElement("option");
  option.value = prov;
  option.textContent = prov;
  provinsiSelect.appendChild(option);
});

provinsiSelect.addEventListener("change", () => {
  kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
  kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
  hasilDiv.classList.add("hidden");

  let prov = provinsiSelect.value;
  if (prov && data[prov]) {
    Object.keys(data[prov]).forEach(kab => {
      let option = document.createElement("option");
      option.value = kab;
      option.textContent = kab;
      kabupatenSelect.appendChild(option);
    });
  }
});

kabupatenSelect.addEventListener("change", () => {
  kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
  hasilDiv.classList.add("hidden");

  let prov = provinsiSelect.value;
  let kab = kabupatenSelect.value;
  if (prov && kab && data[prov][kab]) {
    Object.keys(data[prov][kab]).forEach(kec => {
      let option = document.createElement("option");
      option.value = kec;
      option.textContent = kec;
      kecamatanSelect.appendChild(option);
    });
  }
});

document.getElementById("cari").addEventListener("click", () => {
  let prov = provinsiSelect.value;
  let kab = kabupatenSelect.value;
  let kec = kecamatanSelect.value;

  if (prov && kab && kec) {
    let kode = data[prov][kab][kec];
    hasilDiv.innerHTML = `Kode Pos: <span style="color:#2193b0">${kode}</span>`;
    hasilDiv.classList.remove("hidden");
  } else {
    hasilDiv.innerHTML = "Lengkapi Pilihan Anda";
    hasilDiv.classList.remove("hidden");
  }
});