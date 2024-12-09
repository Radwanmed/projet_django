document.addEventListener("DOMContentLoaded", function () {
    const daysContainer = document.querySelector(".jours");
    const monthElement = document.querySelector(".month");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    const todayBtn = document.querySelector(".today");

    let currentDate = new Date();

    // Charger les événements depuis MySQL
    async function fetchEvents(year, month) {
        try {
            const response = await fetch(`events.php?year=${year}&month=${month}`);
            return await response.json();
        } catch (error) {
            console.error("Erreur lors de la récupération des événements:", error);
            return [];
        }
    }

    // Ajouter un événement dans MySQL
    async function addEvent(date, details) {
        try {
            const response = await fetch("events.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ event_date: date, details }),
            });
            const result = await response.json();
            return result;
        } catch (error) {
            console.error("Erreur lors de l'ajout de l'événement:", error);
            return { status: "error" };
        }
    }

    // Modifier un événement dans MySQL
    async function updateEvent(date, details) {
        try {
            const response = await fetch("events.php", {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ event_date: date, details }),
            });
            const result = await response.json();
            return result;
        } catch (error) {
            console.error("Erreur lors de la modification de l'événement:", error);
            return { status: "error" };
        }
    }

    // Supprimer un événement dans MySQL
    async function deleteEvent(date) {
        try {
            const response = await fetch("events.php", {
                method: "DELETE",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `event_date=${encodeURIComponent(date)}`,
            });
            const result = await response.json();
            return result;
        } catch (error) {
            console.error("Erreur lors de la suppression de l'événement:", error);
            return { status: "error" };
        }
    }

    // Mettre à jour le calendrier
    async function renderCalendar() {
        daysContainer.innerHTML = "";

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const today = new Date();
        const firstDayIndex = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();
        const prevLastDay = new Date(year, month, 0).getDate();

        const months = [
            "Janvier", "Février", "Mars", "Avril", "Mai",
            "Juin", "Juillet", "Août", "Septembre", "Octobre",
            "Novembre", "Décembre"
        ];

        monthElement.textContent = `${months[month]} ${year}`;

        const events = await fetchEvents(year, month + 1);

        // Ajouter les jours du mois précédent
        for (let i = firstDayIndex; i > 0; i--) {
            const dayElement = document.createElement("div");
            dayElement.classList.add("jour", "prev");
            dayElement.textContent = prevLastDay - i + 1;
            daysContainer.appendChild(dayElement);
        }

        // Ajouter les jours du mois courant
        for (let i = 1; i <= lastDay; i++) {
            const dayElement = document.createElement("div");
            dayElement.classList.add("jour");
            dayElement.textContent = i;

            const fullDate = `${year}-${String(month + 1).padStart(2, "0")}-${String(i).padStart(2, "0")}`;
            const event = events.find(e => e.event_date === fullDate);

            if (year === today.getFullYear() && month === today.getMonth() && i === today.getDate()) {
                dayElement.classList.add("today");
            }

            if (event) {
                dayElement.style.backgroundColor = "#4caf50";
                dayElement.style.color = "#fff";

                dayElement.addEventListener("click", () => {
                    openModal(fullDate, event.details);
                });
            } else {
                dayElement.addEventListener("click", () => {
                    openModal(fullDate);
                });
            }

            daysContainer.appendChild(dayElement);
        }
    }

    // Ouvrir une fenêtre modale
    function openModal(date, eventDetails = "") {
        const modal = document.createElement("div");
        modal.classList.add("modal");

        modal.innerHTML = `
            <div class="modal-overlay">
                <div class="modal-content">
                    <button class="close">&times;</button>
                    <h2>Événement pour le ${date}</h2>
                    <textarea placeholder="Entrez les détails de l'événement..." style="background: #333; color: #fff;">${eventDetails}</textarea>
                    ${eventDetails ? `<button id="updateEvent">Modifier</button>`  :` <button id="saveEvent">Ajoute</button>`}
                    ${eventDetails ? `<button id="deleteEvent">Supprimer</button> `: ""}
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        modal.querySelector(".close").addEventListener("click", () => {
            modal.remove();
        });

        modal.querySelector("#saveEvent")?.addEventListener("click", async () => {
            const details = modal.querySelector("textarea").value.trim();
            if (details) {
                await addEvent(date, details);
                modal.remove();
                await renderCalendar();
            } else {
                alert("Veuillez entrer des détails pour l'événement.");
            }
        });

        modal.querySelector("#updateEvent")?.addEventListener("click", async () => {
            const details = modal.querySelector("textarea").value.trim();
            if (details) {
                await updateEvent(date, details);
                modal.remove();
                await renderCalendar();
            } else {
                alert("Veuillez entrer des détails pour l'événement.");
            }
        });

        modal.querySelector("#deleteEvent")?.addEventListener("click", async () => {
            if (confirm("Voulez-vous vraiment supprimer cet événement ?")) {
                await deleteEvent(date);
                modal.remove();
                await renderCalendar();
            }
        });
    }

    prevBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    todayBtn.addEventListener("click", () => {
        currentDate = new Date();
        renderCalendar();
    });

    renderCalendar();
});