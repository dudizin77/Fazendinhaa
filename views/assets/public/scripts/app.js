// Variáveis globais
const API_BASE = 'http://localhost/fazendinhaNOVA/api';

function getUserId() {
    return u.data.id;
}
const user = localStorage.getItem('agrocontrolUser');

const u = JSON.parse(user);

console.log(u.data.id);


// Verificar se está logado ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    const logged = localStorage.getItem('agrocontrolLogged');
    if (!logged) {
        window.location.href = 'login.html';
        return;
    }

    const user = JSON.parse(localStorage.getItem('agrocontrolUser'));
    console.log('Usuário logado:', user);

    // Configurar logout
    const logoutBtn = document.getElementById('logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('agrocontrolLogged');
            localStorage.removeItem('agrocontrolUser');
            localStorage.removeItem('agrocontrolIsAdmin');
            window.location.href = 'login.html';
        });
    }
});

/**
 * Funções para gerenciar ANIMAIS
 */
function listarAnimais() {
    const uid = getUserId();
    fetch(`${API_BASE}/animais/list${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#animaisTable tbody');
        if (data.type === 'success' && data.data && Array.isArray(data.data) && data.data.length > 0) {
            const tbody = document.querySelector('#animaisTable tbody');
            if (tbody) {
                tbody.innerHTML = '';
                data.data.forEach(animal => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${animal.id}</td>
                        <td>${animal.nome}</td>
                        <td>${animal.raca_nome || 'N/A'}</td>
                        <td>${animal.sexo || 'N/A'}</td>
                        <td>${animal.peso || 'N/A'}</td>
                        <td>
                            <button onclick="editarAnimal(${animal.id})" class="btn-edit">Editar</button>
                            <button onclick="deletarAnimal(${animal.id})" class="btn-delete">Deletar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        } else if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Nenhum animal encontrado</td></tr>';
        }
    })
    .catch(error => {
        console.error('Erro ao listar animais:', error);
        const tbody = document.querySelector('#animaisTable tbody');
        if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Erro ao carregar animais</td></tr>';
    });
}



function criarAnimal() {
    const form = new FormData(formAnimal);
    const editId = formAnimal.dataset.editId || null;

    const userId = getUserId();

    if (!form.get('user_id')) {
        form.append('user_id', userId);
    }

    console.log('user_id enviado:', form.get('user_id'));

    const url = editId
        ? `${API_BASE}/animais/${editId}`
        : `${API_BASE}/animais`;

    const method = editId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        body: form
    })
    .then(response => response.json())
    .then(data => {
        console.log('Resposta API:', data);

        if (data.type === 'success') {
            alert(editId
                ? 'Animal atualizado com sucesso!'
                : 'Animal criado com sucesso!'
            );

            delete formAnimal.dataset.editId;

            const submitBtn = formAnimal.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Cadastrar Animal';
            }

            const cancelBtn = document.getElementById('cancelEditBtn');
            if (cancelBtn) {
                cancelBtn.remove();
            }

            listarAnimais();
        } else {
            alert('Erro: ' + (data.message || 'Erro desconhecido'));
        }
    })
    .catch(error => {
        console.error('Erro ao criar/atualizar animal:', error);
    });
}




function editarAnimal(id) {

    const userId = getUserId();

    if (!form.get('user_id')) {
        form.append('user_id', userId);
    }

    const form = new FormData(formAnimal);

    fetch(`${API_BASE}/animais/list/${id}${userId ? '?user_id=' + userId : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            const animal = data.data;
            const form = document.getElementById('formAnimal');
            if (!form) return;
            form.dataset.editId = animal.id;
            form.querySelector('input[name="nome"]').value = animal.nome || '';
            form.querySelector('select[name="raca_id"]').value = animal.raca_id || '';
            form.querySelector('select[name="sexo"]').value = animal.sexo || '';
            form.querySelector('input[name="data_nascimento"]').value = animal.data_nascimento || '';
            form.querySelector('input[name="peso"]').value = animal.peso || '';

            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.textContent = 'Salvar alterações';

            // Adiciona botão cancelar se não existir
            if (!document.getElementById('cancelEditBtn')) {
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.id = 'cancelEditBtn';
                cancelBtn.textContent = 'Cancelar';
                cancelBtn.style.marginLeft = '12px';
                cancelBtn.className = '';
                cancelBtn.onclick = function() {
                    if (form) {
                        delete form.dataset.editId;
                        form.reset();
                        if (submitBtn) submitBtn.textContent = 'Cadastrar Animal';
                        cancelBtn.remove();
                    }
                };
                submitBtn.parentNode.insertBefore(cancelBtn, submitBtn.nextSibling);
            }
        } else {
            alert('Não foi possível carregar os dados do animal');
        }
    })
    .catch(error => {
        console.error('Erro ao carregar animal para edição:', error);
        alert('Erro ao carregar animal para edição');
    });
}

function deletarAnimal(id) {
    if (confirm('Tem certeza que deseja deletar este animal?')) {
        const uid = getUserId();
        fetch(`${API_BASE}/animais/${id}${uid ? '?user_id=' + uid : ''}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                alert('Animal deletado com sucesso!');
                listarAnimais();
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => console.error('Erro ao deletar animal:', error));
    }
}

/**
 * Funções para gerenciar DESPESAS
 */
function listarDespesas() {
    const uid = getUserId();
    fetch(`${API_BASE}/despesas/list${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#despesasTable tbody');
        if (data.type === 'success' && data.data && Array.isArray(data.data) && data.data.length > 0) {
            if (tbody) {
                tbody.innerHTML = '';
                data.data.forEach(despesa => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${despesa.id}</td>
                        <td>${despesa.animal_nome || (despesa.grupo_nome ? despesa.grupo_nome + ' (grupo)' : 'N/A')}</td>
                        <td>${despesa.categoria_nome || 'N/A'}</td>
                        <td>${despesa.descricao}</td>
                        <td>R$ ${parseFloat(despesa.valor).toFixed(2)}</td>
                        <td>${despesa.data_despesa}</td>
                        <td>
                            <button onclick="editarDespesa(${despesa.id})" class="btn-edit">Editar</button>
                            <button onclick="deletarDespesa(${despesa.id})" class="btn-delete">Deletar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        } else if (tbody) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Nenhuma despesa encontrada</td></tr>';
        }
    })
    .catch(error => {
        console.error('Erro ao listar despesas:', error);
        const tbody = document.querySelector('#despesasTable tbody');
        if (tbody) tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Erro ao carregar despesas</td></tr>';
    });
}

function criarDespesa(formData) {
    const form = document.getElementById('formDespesa');
    const editId = form ? form.dataset.editId : null;
    const url = editId ? `${API_BASE}/despesas/${editId}` : `${API_BASE}/despesas/`;
    const method = editId ? 'PUT' : 'POST';

    if (!formData.user_id) formData.user_id = getUserId();
    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            if (editId) alert('Despesa atualizada com sucesso!');
            else alert('Despesa registrada com sucesso!');
            if (form) {
                delete form.dataset.editId;
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.textContent = 'Registrar Despesa';
                const cancelBtn = document.getElementById('cancelDespesaBtn');
                if (cancelBtn) cancelBtn.remove();
                form.reset();
            }
            listarDespesas();
        } else {
            alert('Erro: ' + (data.message || 'Erro desconhecido'));
        }
    })
    .catch(error => console.error('Erro ao criar/atualizar despesa:', error));
}

function editarDespesa(id) {
    const uid = getUserId();
    fetch(`${API_BASE}/despesas/list/${id}${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            const d = data.data;
            const form = document.getElementById('formDespesa');
            if (!form) return;
            form.dataset.editId = d.id;
            const animalSel = form.querySelector('select[name="animal_id"]');
            const grupoSel = form.querySelector('select[name="grupo_id"]');
            if (animalSel) animalSel.value = (d.animal_id !== null && d.animal_id !== undefined) ? d.animal_id : '';
            if (grupoSel) grupoSel.value = (d.grupo_id !== null && d.grupo_id !== undefined) ? d.grupo_id : '';
            if (form.querySelector('select[name="categoria_id"]')) form.querySelector('select[name="categoria_id"]').value = (d.categoria_id !== null && d.categoria_id !== undefined) ? d.categoria_id : '';
            form.querySelector('input[name="descricao"]').value = d.descricao || '';
            form.querySelector('input[name="valor"]').value = d.valor || '';
            form.querySelector('input[name="data_despesa"]').value = d.data_despesa || '';

            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.textContent = 'Salvar alterações';

            if (!document.getElementById('cancelDespesaBtn')) {
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.id = 'cancelDespesaBtn';
                cancelBtn.textContent = 'Cancelar';
                cancelBtn.style.marginLeft = '12px';
                cancelBtn.onclick = function() {
                    delete form.dataset.editId;
                    form.reset();
                    if (submitBtn) submitBtn.textContent = 'Registrar Despesa';
                    cancelBtn.remove();
                };
                submitBtn.parentNode.insertBefore(cancelBtn, submitBtn.nextSibling);
            }
        } else {
            alert('Não foi possível carregar a despesa');
        }
    })
    .catch(error => {
        console.error('Erro ao carregar despesa para edição:', error);
        alert('Erro ao carregar despesa para edição');
    });
}

function deletarDespesa(id) {
    if (confirm('Tem certeza que deseja deletar esta despesa?')) {
        const uid = getUserId();
        fetch(`${API_BASE}/despesas/${id}${uid ? '?user_id=' + uid : ''}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                alert('Despesa deletada com sucesso!');
                listarDespesas();
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => console.error('Erro ao deletar despesa:', error));
    }
}

/**
 * Funções para gerenciar LUCROS
 */
function listarLucros() {
    const uid = getUserId();
    fetch(`${API_BASE}/lucros/list${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#lucrosTable tbody');
        if (data.type === 'success' && data.data && Array.isArray(data.data) && data.data.length > 0) {
            if (tbody) {
                tbody.innerHTML = '';
                data.data.forEach(lucro => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${lucro.id}</td>
                        <td>${lucro.animal_nome || (lucro.grupo_nome ? lucro.grupo_nome + ' (grupo)' : 'N/A')}</td>
                        <td>${lucro.categoria_nome || 'N/A'}</td>
                        <td>${lucro.descricao}</td>
                        <td>R$ ${parseFloat(lucro.valor).toFixed(2)}</td>
                        <td>${lucro.data_lucro}</td>
                        <td>
                            <button onclick="editarLucro(${lucro.id})" class="btn-edit">Editar</button>
                            <button onclick="deletarLucro(${lucro.id})" class="btn-delete">Deletar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        } else if (tbody) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Nenhum lucro encontrado</td></tr>';
        }
    })
    .catch(error => {
        console.error('Erro ao listar lucros:', error);
        const tbody = document.querySelector('#lucrosTable tbody');
        if (tbody) tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Erro ao carregar lucros</td></tr>';
    });
}




function criarLucro() {
    const form = new FormData(formLucro);
    const editId = formLucro.dataset.editId || null;

    const userId = getUserId();

    if (!form.get('user_id')) {
        form.append('user_id', userId);
    }

    console.log('user_id enviado:', form.get('user_id'));

    const url = editId
        ? `${API_BASE}/lucros/${editId}`
        : `${API_BASE}/lucros`;

    const method = editId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        body: form
    })
    .then(response => response.json())
    .then(data => {
        console.log('Resposta API:', data);

        if (data.type === 'success') {
            alert(
                editId
                    ? 'Lucro atualizado com sucesso!'
                    : 'Lucro registrado com sucesso!'
            );

            delete formLucro.dataset.editId;

            const submitBtn = formLucro.querySelector(
                'button[type="submit"]'
            );

            if (submitBtn) {
                submitBtn.textContent = 'Registrar Lucro';
            }

            const cancelBtn = document.getElementById('cancelLucroBtn');

            if (cancelBtn) {
                cancelBtn.remove();
            }

            formLucro.reset();

            listarLucros();
        } else {
            alert('Erro: ' + (data.message || 'Erro desconhecido'));
        }
    })
    .catch(error => {
        console.error('Erro ao criar/atualizar lucro:', error);
    });
}

function editarLucro(id) {
    const uid = getUserId();
    fetch(`${API_BASE}/lucros/list/${id}${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            const d = data.data;
            const form = document.getElementById('formLucro');
            if (!form) return;
            form.dataset.editId = d.id;
            const animalSel = form.querySelector('select[name="animal_id"]');
            const grupoSel = form.querySelector('select[name="grupo_id"]');
            if (animalSel) animalSel.value = (d.animal_id !== null && d.animal_id !== undefined) ? d.animal_id : '';
            if (grupoSel) grupoSel.value = (d.grupo_id !== null && d.grupo_id !== undefined) ? d.grupo_id : '';
            if (form.querySelector('select[name="categoria_id"]')) form.querySelector('select[name="categoria_id"]').value = (d.categoria_id !== null && d.categoria_id !== undefined) ? d.categoria_id : '';
            form.querySelector('input[name="descricao"]').value = d.descricao || '';
            form.querySelector('input[name="valor"]').value = d.valor || '';
            form.querySelector('input[name="data_lucro"]').value = d.data_lucro || '';

            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.textContent = 'Salvar alterações';

            if (!document.getElementById('cancelLucroBtn')) {
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.id = 'cancelLucroBtn';
                cancelBtn.textContent = 'Cancelar';
                cancelBtn.style.marginLeft = '12px';
                cancelBtn.onclick = function() {
                    delete form.dataset.editId;
                    form.reset();
                    if (submitBtn) submitBtn.textContent = 'Registrar Lucro';
                    cancelBtn.remove();
                };
                submitBtn.parentNode.insertBefore(cancelBtn, submitBtn.nextSibling);
            }
        } else {
            alert('Não foi possível carregar o lucro');
        }
    })
    .catch(error => {
        console.error('Erro ao carregar lucro para edição:', error);
        alert('Erro ao carregar lucro para edição');
    });
}

function deletarLucro(id) {
    if (confirm('Tem certeza que deseja deletar este lucro?')) {
        const uid = getUserId();
        fetch(`${API_BASE}/lucros/${id}${uid ? '?user_id=' + uid : ''}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                alert('Lucro deletado com sucesso!');
                listarLucros();
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => console.error('Erro ao deletar lucro:', error));
    }
}

/**
 * Funções para carregar dados em selects
 */
function carregarRacas(selectElement) {
    fetch(`${API_BASE}/racas/list`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            selectElement.innerHTML = '<option value="">Selecione uma raça</option>';
            data.data.forEach(raca => {
                const option = document.createElement('option');
                option.value = raca.id;
                option.textContent = raca.nome;
                selectElement.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Erro ao carregar raças:', error));
}

function carregarAnimais(selectElement) {
    const uid = getUserId();
    fetch(`${API_BASE}/animais/list${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            selectElement.innerHTML = '<option value="">Selecione um animal</option>';
            data.data.forEach(animal => {
                const option = document.createElement('option');
                option.value = animal.id;
                option.textContent = animal.nome;
                selectElement.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Erro ao carregar animais:', error));
}

function carregarGrupos(selectElement) {
    const uid = getUserId();
    fetch(`${API_BASE}/grupos/list${uid ? '?user_id=' + uid : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            selectElement.innerHTML = '<option value="">Nenhum</option>';
            data.data.forEach(g => {
                const option = document.createElement('option');
                option.value = g.id;
                option.textContent = `${g.nome} (x${g.quantidade})`;
                selectElement.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Erro ao carregar grupos:', error));
}

function listarGrupos() {
    const userId = getUserId();

    console.log('user_id:', userId);

    fetch(`${API_BASE}/grupos/list?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Resposta grupos:', data);

            const tbody = document.querySelector('#gruposTable tbody');

            if (data.type === 'success' && Array.isArray(data.data) && data.data.length > 0) {
                if (tbody) {
                    tbody.innerHTML = '';

                    data.data.forEach(g => {
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${g.id}</td>
                            <td>${g.nome}</td>
                            <td>${g.quantidade}</td>
                            <td>
                                <button onclick="editarGrupo(${g.id})" class="btn-edit">
                                    Editar
                                </button>

                                <button onclick="deletarGrupo(${g.id})" class="btn-delete">
                                    Deletar
                                </button>
                            </td>
                        `;

                        tbody.appendChild(tr);
                    });
                }
            } else if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Nenhum grupo encontrado
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Erro ao listar grupos:', error);

            const tbody = document.querySelector('#gruposTable tbody');

            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Erro ao carregar grupos
                        </td>
                    </tr>
                `;
            }
        });
}

function criarGrupo(formData) {



    const form = new FormData(formGrupo);
    const editId = formGrupo.dataset.editId || null;
    const url = editId ? `${API_BASE}/grupos/${editId}` : `${API_BASE}/grupos/`;
    // const method = editId ? 'PUT' : 'POST';

      const userId = getUserId();

    if (!form.get('user_id')) {
        form.append('user_id', userId);
    }

    console.log('user_id enviado:', form.get('user_id'));

    if (!formData.user_id) formData.user_id = getUserId();

    fetch(url, {
        method: 'POST',
        body: form
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            alert(editId ? 'Grupo atualizado!' : 'Grupo criado!');
            if (form) {
                delete form.dataset.editId;
                form.reset();
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.textContent = 'Criar Grupo';
            }
            listarGrupos();
        } else alert('Erro: ' + (data.message || 'Erro desconhecido'));
    })
    .catch(error => console.error('Erro ao criar/atualizar grupo:', error));
}

function editarGrupo(id) {

        const userId = getUserId();

    console.log('user_id:', userId);

    fetch(`${API_BASE}/grupos/list/${id}${userId ? '?user_id=' + userId : ''}`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            const g = data.data;
            const form = document.getElementById('formGrupo');
            if (!form) return;
            form.dataset.editId = g.id;
            form.querySelector('input[name="nome"]').value = g.nome || '';
            form.querySelector('input[name="quantidade"]').value = g.quantidade || 0;
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.textContent = 'Salvar alterações';
            if (!document.getElementById('cancelGrupoBtn')) {
                const cancel = document.createElement('button');
                cancel.type = 'button';
                cancel.id = 'cancelGrupoBtn';
                cancel.textContent = 'Cancelar';
                cancel.style.marginLeft = '12px';
                cancel.onclick = function() {
                    delete form.dataset.editId;
                    form.reset();
                    if (submitBtn) submitBtn.textContent = 'Criar Grupo';
                    cancel.remove();
                };
                submitBtn.parentNode.insertBefore(cancel, submitBtn.nextSibling);
            }
        } else alert('Não foi possível carregar o grupo');
    })
    .catch(error => console.error('Erro ao carregar grupo para edição:', error));
}

function deletarGrupo(id) {
        const userId = getUserId();

    console.log('user_id:', userId);
    
    if (!confirm('Excluir este grupo?')) return;
    fetch(`${API_BASE}/grupos/${id}`, { method: 'DELETE' })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') listarGrupos();
        else alert('Erro: ' + data.message);
    })
    .catch(error => console.error('Erro ao deletar grupo:', error));
}

function carregarCategoriasDespesas(selectElement) {
    fetch(`${API_BASE}/categorias-despesas/list`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            selectElement.innerHTML = '<option value="">Selecione uma categoria</option>';
            data.data.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nome;
                selectElement.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Erro ao carregar categorias:', error));
}

function carregarCategoriasLucros(selectElement) {
    fetch(`${API_BASE}/categorias-lucros/list`)
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success' && data.data) {
            selectElement.innerHTML = '<option value="">Selecione uma categoria</option>';
            data.data.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nome;
                selectElement.appendChild(option);
            });
        }
    })
    .catch(error => console.error('Erro ao carregar categorias:', error));
}
