import { ajax } from './ajax.js';
import { apiBase } from './ajax.js';

function loadMonthlyInterests() {
    const startDate = document.getElementById('monthly_interest_start_date').value;
    const endDate = document.getElementById('monthly_interest_end_date').value;

    if (!startDate || !endDate) {
        alert("Veuillez sélectionner les dates de début et de fin.");
        return;
    }

    ajax('GET', `/prets-clients/monthly-interests?startDate=${startDate}&endDate=${endDate}`, null, (data) => {
        const tableBody = document.getElementById('monthlyInterestTableBody');
        tableBody.innerHTML = '';
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="2" class="p-2 text-center">Aucune donnée disponible pour les dates sélectionnées.</td></tr>';
            document.getElementById('monthlyInterestsSection').classList.remove('hidden');
            return;
        }

        const months = [];
        const totalInterests = [];

        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="p-2">${item.month}</td>
                <td class="p-2">${parseFloat(item.total_interest).toFixed(2)} €</td>
            `;
            tableBody.appendChild(row);
            months.push(item.month);
            totalInterests.push(parseFloat(item.total_interest).toFixed(2));
        });

        document.getElementById('monthlyInterestsSection').classList.remove('hidden');

        // Render chart
        const ctx = document.getElementById('monthlyInterestChart').getContext('2d');
        if (window.monthlyInterestChart) {
            window.monthlyInterestChart.destroy();
        }
        window.monthlyInterestChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Somme des intérêts (€)',
                    data: totalInterests,
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Somme des intérêts (€)'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' €';
                            }
                        }
                    }
                }
            }
        });

    }, (error) => {
        console.error('Erreur lors du chargement des sommes d\'intérêts mensuels:', error);
        alert('Erreur lors du chargement des sommes d\'intérêts mensuels: ' + error);
    });
}

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

    ajax('POST', '/prets-clients/filter', filters, (loans) => {
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
}

function closeLoanDetails() {
    document.getElementById('loanDetails').classList.add('hidden');
}

// Load filter options and initial loan list on page load
window.onload = () => {
    loadFilterOptions();
    filterLoans();
    document.getElementById('showMonthlyInterestsBtn').addEventListener('click', loadMonthlyInterests);
    document.getElementById('buttonFilterLoad').addEventListener('click', filterLoans);
    document.getElementById('closerButton').addEventListener('click', closeLoanDetails);
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