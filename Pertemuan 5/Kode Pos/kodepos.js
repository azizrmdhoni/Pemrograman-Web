const data = {
  "Jawa Timur": {
    "Surabaya": {
      "Wonokromo": {
        "Darmo": "60241",
        "Jagir": "60242",
        "Ngagel": "60246"
      },
      "Tegalsari": {
        "Kedungdoro": "60261",
        "Dr. Sutomo": "60264",
        "Keputran": "60265"
      }
    },
    "Malang": {
      "Klojen": {
        "Oro-Oro Dowo": "65119",
        "Klojen": "65111",
        "Kasin": "65117"
      },
      "Lowokwaru": {
        "Dinoyo": "65144",
        "Ketawanggede": "65145",
        "Tlogomas": "65144"
      }
    }
  },

  "Bali": {
    "Denpasar": {
      "Denpasar Barat": {
        "Padangsambian": "80117",
        "Pemecutan": "80119"
      },
      "Denpasar Timur": {
        "Kesiman": "80237",
        "Sumerta": "80235"
      }
    }
  },

  "DKI Jakarta": {
    "Jakarta Selatan": {
      "Kebayoran Baru": {
        "Gandaria Utara": "12140",
        "Senayan": "12190"
      },
      "Tebet": {
        "Manggarai": "12850",
        "Tebet Barat": "12810"
      }
    },
    "Jakarta Timur": {
      "Cakung": {
        "Penggilingan": "13940",
        "Jatinegara": "13930"
      }
    }
  },

  "Jawa Tengah": {
    "Semarang": {
      "Semarang Tengah": {
        "Miroto": "50134",
        "Pandansari": "50139"
      },
      "Tembalang": {
        "Tembalang": "50275",
        "Bulusan": "50277"
      }
    },
    "Solo": {
      "Banjarsari": {
        "Gilingan": "57134",
        "Keprabon": "57131"
      }
    }
  },

  "Jawa Barat": {
    "Bandung": {
      "Coblong": {
        "Dago": "40135",
        "Lebak Gede": "40132"
      },
      "Lengkong": {
        "Cikawao": "40261",
        "Malabar": "40262"
      }
    },
    "Bekasi": {
      "Bekasi Timur": {
        "Aren Jaya": "17111",
        "Bekasi Jaya": "17112"
      },
      "Bekasi Barat": {
        "Kranji": "17135",
        "Bintara": "17134"
      }
    }
  },

  "Kalimantan Selatan": {
    "Banjarmasin": {
      "Banjarmasin Tengah": {
        "Teluk Dalam": "70117",
        "Kertak Baru Ilir": "70111"
      },
      "Banjarmasin Barat": {
        "Belitung Selatan": "70116",
        "Telawang": "70112"
      }
    }
  },

  "Sulawesi Selatan": {
    "Makassar": {
      "Ujung Pandang": {
        "Losari": "90112",
        "Mangkura": "90113"
      },
      "Panakkukang": {
        "Karampuang": "90231",
        "Paropo": "90233"
      }
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
    let kelurahanList = data[prov][kab][kec];
    let listHTML = `<h3>Daftar Kelurahan di ${kec}:</h3><ul>`;
    Object.keys(kelurahanList).forEach(kel => {
      listHTML += `<li><b>${kel}:</b> ${kelurahanList[kel]}</li>`;
    });
    listHTML += "</ul>";
    hasilDiv.innerHTML = listHTML;
    hasilDiv.classList.remove("hidden");
  } else {
    hasilDiv.innerHTML = "Lengkapi Pilihan Anda";
    hasilDiv.classList.remove("hidden");
  }
});
