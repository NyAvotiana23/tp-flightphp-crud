import {ajax} from "./ajax.js";

document.addEventListener("DOMContentLoaded", () => {
    const client = JSON.parse(localStorage.getItem("client"));
    if (!client) {
        alert("Aucun client connecté. Veuillez vous connecter.");
        window.location.href = "client.js";
        return;
    }

    // Display client information
    document.getElementById("clientName").textContent = `${client.prenom} ${client.nom}`;
    document.getElementById("clientNumber").textContent = client.numero_client;
    document.getElementById("clientEmail").textContent = client.email;

    // Calculate and display balance
    const calculateBalance = (transactions) => {

        const balance = transactions.reduce((sum, t) => {
            return sum + parseFloat(t.montant) ;
        }, 0);
        document.getElementById("clientBalance").textContent = `${balance.toFixed(2)} EUR`;
        document.getElementById("finalBalance").textContent = `${balance.toFixed(2)} EUR`;
    };

    // Fetch and display transactions
    const fetchTransactions = (filters = {}) => {
        const conditions = [];
        if (filters.date) {
            conditions.push({column: "date_mouvement", operator: "=", value: filters.date});
        }
        if (filters.type && filters.type !== "all") {
            conditions.push({column: "type_mouvement", operator: "=", value: filters.type});
        }
        conditions.push({column: "id_client", operator: "=", value: client.id});

        ajax("POST", "/mouvements-bancaires-clients/filter", {conditions}, (response) => {
            const transactions = response;
            const transactionList = document.getElementById("transactionList");
            transactionList.innerHTML = "";
            transactions.forEach(t => {
                console.log(t);
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td class="p-3">${t.date_mouvement}</td>
                    <td class="p-3">${t.id_type_mouvement}</td>
                    <td class="p-3">${parseFloat(t.montant).toFixed(2)} EUR</td>
                    <td class="p-3">${t.description || ''}</td>
                `;
                transactionList.appendChild(row);
            });
            calculateBalance(transactions);
        }, (error) => {
            console.error("Error fetching transactions:", error);
            alert("Erreur lors du chargement des mouvements.");
        });
    };

    // Fetch and populate contract types
    const populateContractTypes = () => {
        ajax("GET", "/types-contrats-activite", null, (response) => {
            const typeContratSelect = document.getElementById("typeContrat");
            typeContratSelect.innerHTML = '<option value="">Sélectionner un type</option>';
            response.forEach(type => {
                const option = document.createElement("option");
                option.value = type.id;
                option.textContent = type.nom_type_contrat;
                typeContratSelect.appendChild(option);
            });
        }, (error) => {
            console.error("Error fetching contract types:", error);
            alert("Erreur lors du chargement des types de contrat.");
        });
    };

    // Fetch and display activities
    const fetchActivities = () => {
        ajax("GET", `/activites-clients?id_client=${client.id}`, null, (response) => {
            const activityList = document.getElementById("activityList");
            activityList.innerHTML = "";
            response.forEach(activity => {
                let row = document.createElement("tr");
                row.innerHTML = `
                        <td class="p-3">${activity.nom_activite}</td>
                        <td class="p-3">${parseFloat(activity.revenu_net_mensuel).toFixed(2)} EUR</td>
                        <td class="p-3">${activity.date_debut}</td>
                        <td class="p-3">${activity.date_fin || ''}</td>
                        <td class="p-3">
                            <button class="editActivity bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600" data-id="${activity.id}">Modifier</button>
                            <button class="deleteActivity bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600" data-id="${activity.id}">Supprimer</button>
                        </td>
                    `;
                activityList.appendChild(row);
            });
        }, (error) => {
            console.error("Error fetching activities:", error);
            alert("Erreur lors du chargement des activités.");
        });
    };
    const fetchTypeMouv = () => {
        ajax("GET", `/types-mouvements-bancaires`, null, (response) => {
            const mouvList = document.getElementById("movementType");
            response.forEach(mouv => {
                const row = document.createElement("option");
                row.value = mouv.id;
                row.textContent = mouv.nom_type_mouvement;
                mouvList.appendChild(row);
            });
        }, (error) => {
            console.error("Error fetching activities:", error);
            alert("Erreur lors du chargement des activités.");
        });
    };

    // Handle activity form submission
    const activityForm = document.getElementById("activityForm");
    const saveButton = document.getElementById("saveActivity");
    const cancelButton = document.getElementById("cancelEdit");

    activityForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const activityId = document.getElementById("activityId").value;
        const data = {
            id_client: client.id,
            id_type_contrat: document.getElementById("typeContrat").value,
            nom_activite: document.getElementById("nomActivite").value,
            revenu_net_mensuel: document.getElementById("revenuNetMensuel").value,
            date_debut: document.getElementById("dateDebut").value,
            date_fin: document.getElementById("dateFin").value || null
        };

        const method = activityId ? "PUT" : "POST";
        const url = activityId ? `/activites-clients/${activityId}` : "/activites-clients";

        ajax(method, url, data, () => {
            alert(activityId ? "Activité mise à jour" : "Activité créée");
            activityForm.reset();
            document.getElementById("activityId").value = "";
            saveButton.textContent = "Enregistrer";
            cancelButton.classList.add("hidden");
            fetchActivities();
        }, (error) => {
            console.error("Error saving activity:", error);
            alert("Erreur lors de l'enregistrement de l'activité.");
        });
    });

    // Handle edit activity
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("editActivity")) {
            const id = e.target.dataset.id;
            ajax("GET", `/activites-clients/${id}`, null, (activity) => {
                document.getElementById("activityId").value = activity.id;
                document.getElementById("typeContrat").value = activity.id_type_contrat;
                document.getElementById("nomActivite").value = activity.nom_activite;
                document.getElementById("revenuNetMensuel").value = activity.revenu_net_mensuel;
                document.getElementById("dateDebut").value = activity.date_debut;
                document.getElementById("dateFin").value = activity.date_fin || "";
                saveButton.textContent = "Mettre à jour";
                cancelButton.classList.remove("hidden");
            });
        }
    });

    // Handle delete activity
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("deleteActivity")) {
            if (confirm("Voulez-vous vraiment supprimer cette activité ?")) {
                const id = e.target.dataset.id;
                ajax("DELETE", `/activites-clients/${id}`, null, () => {
                    alert("Activité supprimée");
                    fetchActivities();
                }, (error) => {
                    console.error("Error deleting activity:", error);
                    alert("Erreur lors de la suppression de l'activité.");
                });
            }
        }
    });

    // Handle cancel edit
    cancelButton.addEventListener("click", () => {
        activityForm.reset();
        document.getElementById("activityId").value = "";
        saveButton.textContent = "Enregistrer";
        cancelButton.classList.add("hidden");
    });

    // Handle filter button
    document.getElementById("filterTransactions").addEventListener("click", () => {
        const filters = {
            date: document.getElementById("transactionDate").value,
            type: document.getElementById("movementType").value
        };
        fetchTransactions(filters);
    });

    // Initial load
    fetchTransactions();
    populateContractTypes();
    fetchActivities();
    fetchTypeMouv();

});