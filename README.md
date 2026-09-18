# Sistema de Gestão de Academia

Sistema web simples para academias controlarem alunos, planos, pagamentos, check-ins e frequência — pensado para uso diário na recepção.

---

## Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Escopo](#escopo)
- [Funcionalidades](#funcionalidades)
- [Regras de Negócio](#regras-de-negócio)
- [Perfis de Acesso](#perfis-de-acesso)
- [Modelo de Dados](#modelo-de-dados)
  - [Entidades](#entidades)
  - [Relacionamentos](#relacionamentos)
- [Módulos do Sistema](#módulos-do-sistema)
- [Tecnologias](#tecnologias)
- [Arquitetura](#arquitetura)
- [Fases de Desenvolvimento](#fases-de-desenvolvimento)
- [Como Executar (sugestão)](#como-executar-sugestão)
- [Roadmap Futuro](#roadmap-futuro)
- [Licença](#licença)

---

## Sobre o Projeto

O objetivo é oferecer um sistema **pequeno, útil e realista** para o dia a dia de uma academia, cobrindo:

- Cadastro e gestão de alunos
- Planos e mensalidades
- Matrículas e renovações
- Pagamentos e controlo de inadimplência
- Check-in diário e frequência
- Alertas de vencimento de plano
- Cadastro de professores
- Perfis de acesso (Recepcionista / Administrador)

É um sistema **web**, acessado por navegador, sem necessidade de instalação local.

---

## Escopo

### Incluído nesta versão

- Cadastro de alunos
- Cadastro de planos (Mensal, Trimestral, etc.)
- Matrícula e renovação de planos
- Registo de pagamentos
- Check-in (marcar presença)
- Consulta de frequência do aluno
- Lista de alunos com plano a vencer (próximos 7 dias)
- Lista de alunos com plano vencido
- Cadastro de professores
- Perfis de acesso diferenciados (Recepcionista e Administrador)

### Fora de escopo nesta versão

- Aulas coletivas
- Treinos personalizados
- Controlo de estoque
- App para o aluno
- Pagamentos online
- Controlo de acesso com biometria/catraca
- Cancelamento e trancamento de matrícula *(planeado para versão futura — ver [Roadmap](#roadmap-futuro))*

---

## Funcionalidades

| Nº | Funcionalidade | Descrição |
|----|-----------------|-----------|
| 1 | Gestão de Alunos | Cadastrar, editar e pesquisar alunos |
| 2 | Gestão de Planos | Criar e editar planos de mensalidade |
| 3 | Matrícula / Renovação | Associar aluno a um plano |
| 4 | Registo de Pagamentos | Guardar histórico de pagamentos |
| 5 | Check-in | Marcar presença do aluno no dia |
| 6 | Frequência do Aluno | Ver quantos dias o aluno veio |
| 7 | Alertas de Vencimento | Mostrar quem está perto de terminar o plano |
| 8 | Alunos Vencidos | Mostrar quem já está com plano vencido |
| 9 | Professores | Cadastro simples de professores |
| 10 | Controlo de Acesso | Permissões diferenciadas entre Recepcionista e Administrador |

---

## Regras de Negócio

1. Só é permitido fazer check-in se o aluno tiver matrícula **Ativa**.
2. Cada aluno só pode ter **um check-in por dia**.
3. Quando a data de fim do plano chega, a matrícula muda automaticamente para **Vencida**.
4. O sistema deve destacar os alunos cujo plano termina nos **próximos 7 dias**.
5. Um aluno só pode ter **uma matrícula ativa** de cada vez.
6. É possível consultar a frequência de qualquer aluno por período (ex.: últimos 30 dias).
7. O check-in é **bloqueado** se a matrícula estiver vencida **ou** se o aluno estiver **inadimplente** (pagamento em atraso), mesmo que a data da matrícula ainda esteja dentro do prazo.
8. Assim que o pagamento em atraso é registado, o status do aluno muda para **Em dia** e o check-in é **liberado automaticamente**, sem necessidade de aprovação manual.
9. Cancelamento e trancamento de matrícula ficam fora do escopo desta versão.

---

## Perfis de Acesso

| Ação | Recepcionista | Administrador |
|------|:--------------:|:--------------:|
| Cadastrar / editar aluno | ✅ | ✅ |
| Fazer matrícula / renovação | ✅ | ✅ |
| Registar pagamento | ✅ | ✅ |
| Fazer check-in | ✅ | ✅ |
| Criar / editar planos (valores) | ❌ | ✅ |
| Apagar pagamentos | ❌ | ✅ |
| Cadastrar professores | ❌ | ✅ |
| Ver relatórios / dashboard completo | ❌ | ✅ |

> Esta divisão de permissões pode ser ajustada conforme a necessidade da academia durante o desenvolvimento.

---

## Modelo de Dados

### Entidades

| Entidade | Informações Principais |
|----------|--------------------------|
| **Aluno** | Nome, telefone, email, data de nascimento, status |
| **Plano** | Nome, duração (em dias), valor, descrição |
| **Matrícula** | Aluno, Plano, data de início, data de fim, valor pago, status, status de pagamento |
| **Pagamento** | Matrícula, valor, data, forma de pagamento |
| **Check-in** | Aluno, data e hora |
| **Professor** | Nome, telefone, especialidade |
| **Utilizador** | Nome, login, senha, perfil (Recepcionista / Administrador) |

### Relacionamentos

| Relação | Cardinalidade | Descrição |
|---------|:---------------:|-----------|
| Aluno → Matrícula | 1 : N | Um aluno pode ter várias matrículas ao longo do tempo, mas apenas uma **Ativa** por vez |
| Plano → Matrícula | 1 : N | Um plano pode estar associado a várias matrículas de alunos diferentes |
| Matrícula → Pagamento | 1 : N | Uma matrícula pode ter vários pagamentos registados (ex.: parcelas, renovações) |
| Aluno → Check-in | 1 : N | Um aluno pode ter vários check-ins, no máximo um por dia |
| Utilizador → (sistema) | 1 : N | Um utilizador realiza ações no sistema; não se relaciona diretamente com Aluno/Plano |
| Professor → (sistema) | — | Cadastro independente nesta versão, sem relação com turmas ou alunos |

Diagrama simplificado:

```mermaid
erDiagram
    ALUNO ||--o{ MATRICULA : possui
    PLANO ||--o{ MATRICULA : define
    MATRICULA ||--o{ PAGAMENTO : gera
    ALUNO ||--o{ CHECKIN : realiza
    UTILIZADOR ||--o{ ALUNO : gerencia
    PROFESSOR {
        string nome
        string telefone
        string especialidade
    }
```

> `PROFESSOR` e `UTILIZADOR` são cadastros independentes nesta versão, sem relação direta com as demais entidades.

---

## Módulos do Sistema

1. Alunos
2. Planos
3. Matrículas e Pagamentos
4. Check-in e Frequência
5. Professores
6. Utilizadores e Permissões
7. Dashboard (resumo com alertas de vencimento)

---

## Tecnologias

| Camada | Sugestão |
|--------|----------|
| Backend | Node.js ou Java |
| Frontend | React ou Angular |
| Base de Dados | PostgreSQL ou MySQL |
| Autenticação | Login com utilizador e senha, com perfis de acesso (Recepcionista / Administrador) |
| Hospedagem | Cloud (ex.: Railway, Render, AWS ou VPS) — sistema é **web**, sem versão local |

---

## Arquitetura

Visão geral simplificada (sugestão):

```
[ Navegador (React/Angular) ]
            │  HTTPS
            ▼
[ API Backend (Node.js/Java) ]
            │
            ▼
[ Base de Dados (PostgreSQL/MySQL) ]
```

- Autenticação via login + senha, com sessão/token (ex.: JWT)
- Acesso simultâneo de Recepção e Administração, com permissões diferentes por perfil
- Regras de negócio (check-in, vencimento, inadimplência) aplicadas no backend, nunca só no frontend

---

## Fases de Desenvolvimento

| Fase | O que fazer | Objetivo |
|------|-------------|----------|
| 1 | Cadastro de Alunos + Planos + Matrículas | Base do sistema |
| 2 | Pagamentos + Check-in + Regras de inadimplência | Operação diária |
| 3 | Frequência + Alertas de Vencimento | Relatórios úteis |
| 4 | Professores + Perfis de Acesso + Ajustes finais | Finalização |

---

## Como Executar (sugestão)

> Estrutura de exemplo — ajustar conforme a stack final escolhida.

```bash
# Clonar o repositório
git clone https://github.com/sua-organizacao/gestao-academia.git
cd gestao-academia

# Backend
cd backend
npm install
npm run dev

# Frontend
cd ../frontend
npm install
npm start
```

Variáveis de ambiente sugeridas (`.env`):

```
DATABASE_URL=postgresql://usuario:senha@localhost:5432/academia
JWT_SECRET=defina_uma_chave_secreta
PORT=3000
```

---

## Roadmap Futuro

Funcionalidades fora do escopo da versão atual, mas planeadas para o futuro:

- Cancelamento e trancamento de matrícula
- Aulas coletivas e agenda de turmas
- Treinos personalizados
- Controlo de estoque
- App para o aluno
- Pagamentos online
- Controlo de acesso com biometria/catraca

---

## Licença

Definir conforme a política da organização (ex.: MIT, proprietária, uso interno).
