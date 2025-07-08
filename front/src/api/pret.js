// Fetch loan types, repayment types, and statuses on page load
function loadFilterOptions() {
    // Fetch loan types
    ajax('GET', '/types-prets', null, (loanTypes) => {
        const loanTypeSelect = document.getElementById('id_type_pret');
        loanTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = type.nom_type_pret;
            loanTypeSelect.appendChild(option);
        });
    }, (error) => {
        console.error('Erreur lors du chargement des types de prêt:', error);
    });

    // Fetch repayment types
    ajax('GET', '/types-remboursements', null, (repaymentTypes) => {
        const repaymentTypeSelect = document.getElementById('id_type_remboursement');
        repaymentTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = type.nom_type_remboursement;
            repaymentTypeSelect.appendChild(option);
        });
    }, (error) => {
        console.error('Erreur lors du chargement des types de remboursement:', error);
    });

    // Fetch status types
    ajax('GET', '/status-contrats', null, (statuses) => {
        const statusSelect = document.getElementById('id_status_contrat');
        statuses.forEach(status => {
            const option = document.createElement('option');
            option.value = status.id;
            option.textContent = status.libelle;
            statusSelect.appendChild(option);
        });
    }, (error) => {
        console.error('Erreur lors du chargement des statuts:', error);
    });
}

// Filter loans based on form input
function filterLoans() {
    const filters = {
        date_debut_pret: document.getElementById('date_debut_pret').value,
        id_type_pret: document.getElementById('id_type_pret').value,
        id_type_remboursement: document.getElementById('id_type_remboursement').value,
        id_status_contrat: document.getElementById('id_status_contrat').value
    };

    ajax('POST', '/pret-clients/filter', filters, (loans) => {
        const loanTable = document.getElementById('loanTable');
        loanTable.innerHTML = '';
        loans.forEach(loan => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-custom-gray-purple cursor-pointer';
            row.onclick = () => showLoanDetails(loan.id);
            row.innerHTML = `
                    <td class="p-4">${loan.client_prenom} ${loan.client_nom}</td>
                    <td class="p-4">${loan.montant_pret} €</td>
                    <td class="p-4">${loan.nom_type_pret}</td>
                    <td class="p-4">${loan.date_debut_pret}</td>
                    <td class="p-4">${loan.status_libelle || 'N/A'}</td>
                `;
            loanTable.appendChild(row);
        });
    }, (error) => {
        console.error('Erreur lors du filtrage des prêts:', error);
    });
}

// Fetch and display loan details
function showLoanDetails(loanId) {
    ajax('GET', `/pret-clients/${loanId}/details`, null, (data) => {
        document.getElementById('loanId').textContent = loanId;
        document.getElementById('contractId').textContent = data.contract.id;
        document.getElementById('contractUuid').textContent = data.contract.uuid;
        document.getElementById('repaymentType').textContent = data.contract.repaymentType;
        document.getElementById('revenueRate').textContent = data.contract.revenueRate + '%';
        document.getElementById('insuranceRate').textContent = data.contract.insuranceRate + '%';
        document.getElementById('loanDuration').textContent = data.contract.duration;
        document.getElementById('loanAmount').textContent = data.contract.amount + ' €';
        document.getElementById('dueDate').textContent = data.contract.dueDate;
        document.getElementById('clientName').textContent = data.contract.client;
        document.getElementById('loanType').textContent = data.contract.loanType;
        document.getElementById('contractStatus').textContent = data.status ? data.status.libelle : 'N/A';
        document.getElementById('statusDate').textContent = data.status ? data.status.date : 'N/A';
        document.getElementById('downloadPdfLink').href = `${apiBase}/prets-clients/${loanId}/pdf`;

        const repaymentTable = document.getElementById('repaymentTable');
        repaymentTable.innerHTML = '';
        data.repayments.forEach(repayment => {
            const row = document.createElement('tr');
            row.innerHTML = `
                    <td class="p-2">${repayment.index_period}</td>
                    <td class="p-2">${repayment.date_retour || 'N/A'}</td>
                    <td class="p-2">${repayment.total_due} €</td>
                    <td class="p-2">${repayment.interet} €</td>
                    <td class="p-2">${repayment.capital_rembourse} €</td>
                    <td class="p-2">${repayment.capital_restant} €</td>
                `;
            repaymentTable.appendChild(row);
        });

        document.getElementById('loanDetails').classList.remove('hidden');
    }, (error) => {
        console.error('Erreur lors du chargement des détails du prêt:', error);
    });

    const validateBtn = document.getElementById('validateContractBtn');

    // Vérifie si le statut est "En attente"
    if (data.status && data.status.libelle === 'En attente') {
        validateBtn.classList.remove('hidden');

        validateBtn.onclick = () => {
            // Requête POST vers mouvement-status-contrat
            const payload = {
                id_contrat_pret: data.contract.id,
                id_status_contrat: 4 // ← ID correspondant à "Actif", à ajuster si besoin
            };

            ajax('POST', '/mouvement-status-contrat', payload, (response) => {
                alert('Contrat validé avec succès !');
                validateBtn.classList.add('hidden');
                filterLoans(); // Recharge la liste
                closeLoanDetails(); // Ferme les détails
            }, (error) => {
                console.error("Erreur validation contrat:", error);
                alert("Échec de la validation.");
            });
        };
    } else {
        validateBtn.classList.add('hidden');
    }


}

function closeLoanDetails() {
    document.getElementById('loanDetails').classList.add('hidden');
}

// Load filter options and initial loan list on page load
window.onload = () => {
    loadFilterOptions();
    filterLoans();
};

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.style.transform = 'translateY(-100%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }
});