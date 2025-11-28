<?php
	session_start();
	if((!ISSET($_SESSION['usuario_nome']) == true) and (!isset($_SESSION['usuario_email']) == true) and (!isset($_SESSION['usuario_id']) == true)){
		unset($_SESSION['email']);
		unset($_SESSION['senha']);
		header('Location: login.php');
	}
    $nome_seguro = htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaskFlow - Minhas Tarefas</title>
  <link rel="stylesheet" href="css/sistema.css">
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container header-content">
      <a href="index.html" class="logo">
        <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 11l3 3L22 4"></path>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
        </svg>
        <span>TaskFlow</span>
      </a>
      <a href="login.html" class="btn btn-outline btn-sm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Sair
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main">
    <div class="container">
      <div class="tasks-wrapper">
        <h1 class="page-title">Minhas Tarefas</h1>

        <!-- Add Task Form -->
        <div class="add-task-form">
          <input type="text" id="taskInput" class="input" placeholder="Digite uma nova tarefa...">
          <button class="btn btn-primary" onclick="addTask()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Adicionar
          </button>
        </div>

        <!-- Tasks Table -->
        <div class="table-container">
          <table class="tasks-table">
            <thead>
              <tr>
                <th class="col-status">Status</th>
                <th class="col-task">Tarefa</th>
                <th class="col-date">Data</th>
                <th class="col-actions">Ações</th>
              </tr>
            </thead>
            <tbody id="tasksList">
              <tr>
                <td>
                  <input type="checkbox" class="checkbox" onchange="toggleTask(this)">
                </td>
                <td class="task-title">Estudar React</td>
                <td class="task-date">28/11/2024</td>
                <td>
                  <button class="btn-delete" onclick="deleteTask(this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </button>
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" class="checkbox" checked onchange="toggleTask(this)">
                </td>
                <td class="task-title completed">Fazer exercícios</td>
                <td class="task-date">27/11/2024</td>
                <td>
                  <button class="btn-delete" onclick="deleteTask(this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </button>
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" class="checkbox" onchange="toggleTask(this)">
                </td>
                <td class="task-title">Ler um livro</td>
                <td class="task-date">26/11/2024</td>
                <td>
                  <button class="btn-delete" onclick="deleteTask(this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Stats -->
        <div class="stats">
          <span>Total: <span id="totalTasks">3</span> tarefas</span>
          <span>Concluídas: <span id="completedTasks">1</span></span>
          <span>Pendentes: <span id="pendingTasks">2</span></span>
        </div>
      </div>
    </div>
  </main>

  <script>
    function addTask() {
      const input = document.getElementById('taskInput');
      const value = input.value.trim();
      if (!value) return;

      const tbody = document.getElementById('tasksList');
      const today = new Date().toLocaleDateString('pt-BR');
      
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>
          <input type="checkbox" class="checkbox" onchange="toggleTask(this)">
        </td>
        <td class="task-title">${value}</td>
        <td class="task-date">${today}</td>
        <td>
          <button class="btn-delete" onclick="deleteTask(this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
          </button>
        </td>
      `;
      tbody.appendChild(row);
      input.value = '';
      updateStats();
    }

    function toggleTask(checkbox) {
      const title = checkbox.closest('tr').querySelector('.task-title');
      title.classList.toggle('completed', checkbox.checked);
      updateStats();
    }

    function deleteTask(btn) {
      btn.closest('tr').remove();
      updateStats();
    }

    function updateStats() {
      const rows = document.querySelectorAll('#tasksList tr');
      const total = rows.length;
      const completed = document.querySelectorAll('#tasksList .checkbox:checked').length;
      document.getElementById('totalTasks').textContent = total;
      document.getElementById('completedTasks').textContent = completed;
      document.getElementById('pendingTasks').textContent = total - completed;
    }

    document.getElementById('taskInput').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') addTask();
    });
  </script>
</body>
</html>

