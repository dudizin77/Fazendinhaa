const PROFILE_API_URL = new URL("../api/", window.location.href);
let currentProfile = null;
let photoPreviewUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    const session = readSession();
    const token = session?.data?.token || session?.token;

    if (!token) {
        window.location.href = "login.html";
        return;
    }

    document.querySelector("[data-profile-password-form]")?.addEventListener("submit", updatePassword);
    document.querySelector("[data-profile-photo-form]")?.addEventListener("submit", updatePhoto);
    document.querySelector("[data-profile-photo-input]")?.addEventListener("change", previewPhoto);
    window.addEventListener("pagehide", revokePhotoPreview, { once: true });

    void loadProfile();
});

function readSession() {
    const storedSession = localStorage.getItem("agrocontrolUser");
    if (!storedSession) {
        return null;
    }

    try {
        return JSON.parse(storedSession);
    } catch (error) {
        console.error("Não foi possível ler os dados da sessão.", error);
        return null;
    }
}

function getToken() {
    const session = readSession();
    return session?.data?.token || session?.token || "";
}

async function request(endpoint, options = {}) {
    const token = getToken();
    const headers = new Headers(options.headers || {});
    headers.set("Authorization", `Bearer ${token}`);

    const response = await fetch(new URL(endpoint, PROFILE_API_URL), {
        ...options,
        headers
    });

    const rawResponse = await response.text();

    let payload;

    try {
        payload = JSON.parse(rawResponse);
    } catch (error) {
        console.error("Resposta do PHP:", rawResponse);
        throw new Error("O servidor retornou uma resposta inválida.");
    }

    console.log("Resposta da API:", endpoint, payload);

    if (!response.ok || payload.code >= 400) {
        throw new Error(payload.message || "Erro ao comunicar com o servidor.");
    }

    return payload;
}

async function loadProfile() {
    try {
        const response = await request("users/me");

        if (!response.data) {
            throw new Error("O servidor não enviou os dados do usuário.");
        }

        currentProfile = response.data;
        renderProfile(currentProfile);

    } catch (error) {
        console.error("Erro ao carregar perfil:", error);

        showFeedback(
            "[data-profile-photo-feedback]",
            error.message,
            "error"
        );

        showFeedback(
            "[data-profile-password-feedback]",
            error.message,
            "error"
        );
    }
}

function renderProfile(user) {
    const safeName = user.name || "Produtor AgroControl";
    document.querySelector("[data-profile-name]").textContent = safeName;
    document.querySelector("[data-profile-email]").textContent = user.email || "";
    const initials = getInitials(safeName);
    document.querySelector("[data-profile-initials]").textContent = initials;
    showProfilePhoto(user.photo);

    const storedSession = readSession();
    if (storedSession?.data) {
        storedSession.data = { ...storedSession.data, ...user };
        localStorage.setItem("agrocontrolUser", JSON.stringify(storedSession));
    }
}

async function updatePassword(event) {
    event.preventDefault();
    const form = event.currentTarget;
    const button = form.querySelector("[type='submit']");
    const currentPassword = form.elements.namedItem("current_password").value;
    const newPassword = form.elements.namedItem("new_password").value;
    const confirmPassword = form.elements.namedItem("confirm_password").value;

    if (newPassword.length < 8) {
        showFeedback("[data-profile-password-feedback]", "A nova senha deve ter pelo menos 8 caracteres.", "error");
        return;
    }
    if (newPassword !== confirmPassword) {
        showFeedback("[data-profile-password-feedback]", "A confirmação não corresponde à nova senha.", "error");
        return;
    }
    if (!currentProfile?.name || !currentProfile?.email) {
        showFeedback("[data-profile-password-feedback]", "Não foi possível carregar os dados do perfil. Atualize a página e tente novamente.", "error");
        return;
    }

    setBusy(button, true, "Salvando...");
    showFeedback("[data-profile-password-feedback]", "");
    try {
        const response = await request("users/update", {
            method: "PUT",
            body: new URLSearchParams({
                name: currentProfile.name,
                email: currentProfile.email,
                current_password: currentPassword,
                new_password: newPassword
            })
        });

        currentProfile = { ...currentProfile, ...response.data };
        renderProfile(currentProfile);
        form.reset();
        showFeedback("[data-profile-password-feedback]", response.message || "Senha atualizada com sucesso.", "success");
    } catch (error) {
        showFeedback("[data-profile-password-feedback]", error.message, "error");
    } finally {
        setBusy(button, false, "Salvar nova senha");
    }
}

async function updatePhoto(event) {
    event.preventDefault();
    const form = event.currentTarget;
    const button = form.querySelector("[type='submit']");
    const input = form.elements.namedItem("photo");
    const photo = input.files[0];

    if (!photo) {
        showFeedback("[data-profile-photo-feedback]", "Selecione uma imagem para continuar.", "error");
        return;
    }
    if (photo.size > 5 * 1024 * 1024) {
        showFeedback("[data-profile-photo-feedback]", "A imagem deve ter no máximo 5 MB.", "error");
        return;
    }
    if (!["image/jpeg", "image/png", "image/webp"].includes(photo.type)) {
        showFeedback("[data-profile-photo-feedback]", "Escolha uma imagem JPG, PNG ou WEBP.", "error");
        return;
    }

    setBusy(button, true, "Enviando...");
    showFeedback("[data-profile-photo-feedback]", "");
    try {
        const response = await request("users/photo", {
            method: "POST",
            body: new FormData(form)
        });

        currentProfile = { ...currentProfile, photo: response.data.photo };
        renderProfile(currentProfile);
        form.reset();
        document.querySelector("[data-selected-file]").textContent = "Nenhuma imagem selecionada";
        revokePhotoPreview();
        showFeedback("[data-profile-photo-feedback]", response.message || "Foto atualizada com sucesso.", "success");
    } catch (error) {
        showFeedback("[data-profile-photo-feedback]", error.message, "error");
    } finally {
        setBusy(button, false, "Atualizar foto");
    }
}

function previewPhoto(event) {
    const photo = event.currentTarget.files[0];
    revokePhotoPreview();
    if (!photo) {
        document.querySelector("[data-selected-file]").textContent = "Nenhuma imagem selecionada";
        showProfilePhoto(currentProfile?.photo);
        return;
    }

    document.querySelector("[data-selected-file]").textContent = photo.name;
    photoPreviewUrl = URL.createObjectURL(photo);
    showProfilePhoto(photoPreviewUrl);
}

function showProfilePhoto(photo) {
    const image = document.querySelector("[data-profile-photo]");
    const initials = document.querySelector("[data-profile-initials]");

    image.onload = () => {
        image.hidden = false;
        initials.hidden = true;
    };
    image.onerror = () => {
        image.hidden = true;
        initials.hidden = false;
    };

    if (photo) {
        image.src = photo;
    } else {
        image.removeAttribute("src");
        image.hidden = true;
        initials.hidden = false;
    }
}

function getInitials(name) {
    return name.split(" ").filter(Boolean).slice(0, 2).map((part) => part[0]).join("").toUpperCase() || "AC";
}

function showFeedback(selector, message, type = "") {
    const element = document.querySelector(selector);
    if (!element) {
        return;
    }

    element.textContent = message;
    element.className = `feedback${type ? ` is-${type}` : ""}`;
}

function setBusy(button, busy, label) {
    button.disabled = busy;
    button.textContent = busy ? "Aguarde..." : label;
}

function revokePhotoPreview() {
    if (photoPreviewUrl) {
        URL.revokeObjectURL(photoPreviewUrl);
        photoPreviewUrl = null;
    }
}
