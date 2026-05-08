<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OSYSTEM</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <style>
        :root{
            --os-navy-900:#08152c;
            --os-navy-800:#0b1f45;
            --os-navy-700:#12356e;
            --os-blue-500:#2f6bff;
            --os-blue-400:#6aa6ff;
            --os-red-neon:#ff1744;
            --os-bg:#f4f7ff;
        }

        body{
            background: radial-gradient(1200px 600px at 80% -10%, rgba(106,166,255,.35), rgba(244,247,255,0) 55%),
                        radial-gradient(900px 500px at 10% 0%, rgba(47,107,255,.20), rgba(244,247,255,0) 60%),
                        var(--os-bg);
        }

        .main-sidebar{
            background: linear-gradient(180deg, var(--os-blue-400) 0%, var(--os-blue-500) 45%, #3a36ff 100%) !important;
        }

        .main-sidebar .brand-link{
            border-bottom: 1px solid rgba(255,255,255,.20) !important;
        }

        .main-sidebar .brand-link, .main-sidebar .brand-link .brand-text{
            color: #fff !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link{
            color: rgba(255,255,255,.92) !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover{
            background: rgba(255,255,255,.10) !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active{
            background: linear-gradient(90deg, rgba(255,255,255,.20) 0%, rgba(255,255,255,.12) 45%, rgba(255,255,255,.08) 100%) !important;
            border-left: 4px solid var(--os-red-neon) !important;
            box-shadow: 0 10px 24px rgba(8,21,44,.25);
        }

        .main-header.navbar{
            background: rgba(255,255,255,.80) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(18,53,110,.10) !important;
        }

        .content-wrapper{
            background: transparent !important;
        }

        .card{
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(8,21,44,.08);
            border: 1px solid rgba(18,53,110,.08);
        }

        .card-header{
            background: rgba(255,255,255,.70);
            border-bottom: 1px solid rgba(18,53,110,.08);
        }

        .btn-primary{
            background: linear-gradient(90deg, var(--os-blue-500), #3a36ff) !important;
            border: none !important;
            box-shadow: 0 10px 22px rgba(47,107,255,.25);
        }

        .btn-primary:hover{
            filter: brightness(1.03);
        }

        .btn-danger{
            background: var(--os-red-neon) !important;
            border-color: var(--os-red-neon) !important;
            box-shadow: 0 10px 22px rgba(255,23,68,.18);
        }

        .badge-danger{
            background: var(--os-red-neon) !important;
        }

        .card-primary.card-outline{
            border-top: 3px solid var(--os-blue-500) !important;
        }

        .small-box{
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(8,21,44,.10);
        }

        .small-box.bg-info{
            background: linear-gradient(135deg, var(--os-blue-400), var(--os-blue-500)) !important;
        }

        .small-box.bg-success{
            background: linear-gradient(135deg, #10b981, #22c55e) !important;
        }

        .small-box.bg-warning{
            background: linear-gradient(135deg, #f59e0b, #f97316) !important;
        }

        .icheck-primary > input:first-child:checked + label::before{
            background-color: var(--os-blue-500) !important;
            border-color: var(--os-blue-500) !important;
        }

        .icheck-primary > input:first-child:not(:checked):not(:disabled):hover + label::before{
            border-color: rgba(255,255,255,.70) !important;
        }

        .os-login{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background:
                radial-gradient(900px 500px at 70% 30%, rgba(47,107,255,.35), rgba(8,21,44,0) 60%),
                radial-gradient(800px 420px at 20% 20%, rgba(106,166,255,.22), rgba(8,21,44,0) 65%),
                linear-gradient(135deg, #040816 0%, var(--os-navy-900) 45%, #030713 100%);
        }

        .os-login-frame{
            position: relative;
          
            padding: 56px 56px 44px;
            background: linear-gradient(180deg, rgba(7,25,58,.65), rgba(4,12,28,.55));
            border: 1px solid rgba(106,166,255,.55);
            border-radius: 12px;
            box-shadow:
                0 0 0 1px rgba(106,166,255,.18) inset,
                0 26px 70px rgba(0,0,0,.45),
                0 0 60px rgba(47,107,255,.20);
            overflow: hidden;
        }

        .os-login-frame::before{
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 180px;
            height: 18px;
            background: linear-gradient(90deg, rgba(0,0,0,0), rgba(106,166,255,.45), rgba(0,0,0,0));
        }

        .os-login-notch{
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 160px;
            height: 26px;
            background: linear-gradient(180deg, rgba(106,166,255,.35), rgba(47,107,255,.10));
            border: 1px solid rgba(106,166,255,.60);
            border-top: none;
            clip-path: polygon(10% 0, 90% 0, 100% 100%, 0 100%);
            box-shadow: 0 12px 28px rgba(47,107,255,.20);
        }

        .os-corner{
            position: absolute;
            width: 28px;
            height: 28px;
            border: 2px solid rgba(106,166,255,.80);
            box-shadow: 0 0 14px rgba(106,166,255,.35);
        }

        .os-corner.tl{ top: 14px; left: 14px; border-right: none; border-bottom: none; }
        .os-corner.tr{ top: 14px; right: 14px; border-left: none; border-bottom: none; }
        .os-corner.bl{ bottom: 14px; left: 14px; border-right: none; border-top: none; }
        .os-corner.br{ bottom: 14px; right: 14px; border-left: none; border-top: none; }

        .os-login-title{
            text-align: center;
            letter-spacing: .24em;
            font-weight: 800;
            color: rgba(253, 253, 253, 0.95);
            text-shadow: 0 0 18px rgba(106,166,255,.25);
            margin-bottom: 22px;
            font-size: 2rem;

        }

        .os-login-field{
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border: 1px solid rgba(106,166,255,.45);
            border-radius: 6px;
            background: rgba(3,10,24,.35);
            box-shadow: 0 0 0 1px rgba(106,166,255,.10) inset;
        }

        .os-login-field i{
            color: rgba(106,166,255,.85);
            width: 18px;
            text-align: center;
        }

        .os-login-field input{
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: rgba(255,255,255,.92);
            padding: 2px 0;
        }

        .os-login-field input::placeholder{
            color: rgba(255,255,255,.45);
        }

        .os-login-btn{
            width: 100%;
            height: 42px;
            border-radius: 8px;
            border: 1px solid rgba(106,166,255,.55);
            background: linear-gradient(90deg, rgba(47,107,255,.85), rgba(58,54,255,.85));
            color: #fff;
            font-weight: 700;
            letter-spacing: .06em;
            box-shadow: 0 12px 26px rgba(47,107,255,.25);
        }

        .os-login-btn:disabled{
            opacity: .65;
        }

        .os-login-hint{
            text-align: center;
            color: rgba(255,255,255,.55);
            margin-top: 16px;
            font-size: .9rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div id="app">
@verbatim
    <div v-if="!auth.token" class="os-login">
        <div class="os-login-frame">
            <div class="os-login-notch"></div>
            <span class="os-corner tl"></span>
            <span class="os-corner tr"></span>
            <span class="os-corner bl"></span>
            <span class="os-corner br"></span>
            
             <div class="os-login-title">OSystem</div>

            <div v-if="ui.alert" class="alert alert-danger" role="alert" style="background: rgba(255,23,68,.10); border-color: rgba(255,23,68,.35); color: rgba(255,255,255,.92);">
                {{ ui.alert }}
            </div>

            <form @submit.prevent="login">
                <div class="os-login-field mb-3">
                    <i class="fas fa-user"></i>
                    <input v-model.trim="loginForm.email" type="email" placeholder="Usuário / Email" required>
                </div>

                <div class="os-login-field mb-3">
                    <i class="fas fa-lock"></i>
                    <input v-model="loginForm.password" type="password" placeholder="Senha" required>
                </div>

                <button type="submit" class="os-login-btn" :disabled="isBusy">
                    <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> ENTRANDO</span>
                    <span v-else>ENTRAR</span>
                </button>
            </form>

            <div class="os-login-hint">
                ©2026 Grupo Orix. 
            </div>
        </div>
    </div>

    <div v-else class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3 d-none d-sm-inline">
                    <span class="text-muted">Olá, {{ auth.user ? auth.user.name : '' }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#/dashboard" class="brand-link">
                <img v-if="company && company.logo_image" :src="company.logo_image" alt="Logo" class="brand-image " style="opacity: .9">
                <span class="brand-text font-weight-light ml-2"><b>OS</b>YSTEM</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/dashboard" class="nav-link" :class="{ active: currentView === 'dashboard' }">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#/orders" class="nav-link" :class="{ active: currentView === 'orders' }">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>{{ isAdmin ? 'Ordens de Serviço' : 'Minhas OS' }}</p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/clients" class="nav-link" :class="{ active: currentView === 'clients' }">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/services" class="nav-link" :class="{ active: currentView === 'services' }">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Serviços</p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/company" class="nav-link" :class="{ active: currentView === 'company' }">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Empresa</p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/email" class="nav-link" :class="{ active: currentView === 'email' }">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Config. Email</p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a href="#/users" class="nav-link" :class="{ active: currentView === 'users' }">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div v-if="isBusy" class="overlay-wrapper">
                <div class="overlay dark">
                    <i class="fas fa-2x fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ titleForView }}</h1>
                        </div>
                        <div class="col-sm-6" v-if="breadcrumbs.length">
                            <ol class="breadcrumb float-sm-right">
                                <li v-for="(b, idx) in breadcrumbs" :key="'bc'+idx" class="breadcrumb-item" :class="{ active: idx === breadcrumbs.length - 1 }">
                                    <a v-if="idx !== breadcrumbs.length - 1" :href="b.href">{{ b.text }}</a>
                                    <span v-else>{{ b.text }}</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div v-if="ui.notice" class="alert alert-success" role="alert">
                        {{ ui.notice }}
                    </div>

                    <div v-if="currentView === 'dashboard' && isAdmin" class="row">
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ dashboard.open }}</h3>
                                    <p>OS Abertas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ dashboard.finalized }}</h3>
                                    <p>OS Finalizadas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>R$ {{ formatMoney(dashboard.revenue_total) }}</h3>
                                    <p>Faturamento total</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'clients' && isAdmin" class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="input-group" style="max-width: 420px;">
                                    <input v-model.trim="clients.filters.q" class="form-control" placeholder="Buscar (nome, documento, telefone, email)" @input="debouncedFetchClients()">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" @click="fetchClients(1)"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <button v-if="!isClient" class="btn btn-primary" @click="openClientModal()"><i class="fas fa-plus"></i> Novo cliente</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Telefone</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th style="width: 130px;">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="c in clients.items" :key="c.id">
                                    <td>{{ c.name }}</td>
                                    <td>{{ c.document }}</td>
                                    <td>{{ c.phone }}</td>
                                    <td class="d-none d-md-table-cell">{{ c.email || '-' }}</td>
                                    <td>
                                        <template v-if="isAdmin">
                                            <button class="btn btn-sm btn-warning mr-1" @click="openClientModal(c)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" @click="deleteClient(c)"><i class="fas fa-trash"></i></button>
                                        </template>
                                        <span v-else class="text-muted">-</span>
                                    </td>
                                </tr>
                                <tr v-if="clients.items.length === 0">
                                    <td colspan="5" class="text-center text-muted p-4">Nenhum cliente encontrado.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Página {{ clients.page }} de {{ clients.lastPage }}
                                </div>
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item" :class="{ disabled: clients.page <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="fetchClients(clients.page - 1)">«</a>
                                    </li>
                                    <li v-for="p in pageWindow(clients.page, clients.lastPage)" :key="'cp'+p" class="page-item" :class="{ active: p === clients.page }">
                                        <a class="page-link" href="#" @click.prevent="fetchClients(p)">{{ p }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: clients.page >= clients.lastPage }">
                                        <a class="page-link" href="#" @click.prevent="fetchClients(clients.page + 1)">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'services' && isAdmin" class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="input-group" style="max-width: 420px;">
                                    <input v-model.trim="services.filters.q" class="form-control" placeholder="Buscar (nome, descrição)" @input="debouncedFetchServices()">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" @click="fetchServices(1)"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <button v-if="!isClient" class="btn btn-primary" @click="openServiceModal()"><i class="fas fa-plus"></i> Novo serviço</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th v-if="isAdmin">Valor</th>
                                    <th style="width: 130px;">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="s in services.items" :key="s.id">
                                    <td>{{ s.name }}</td>
                                    <td>{{ s.description || '-' }}</td>
                                    <td v-if="isAdmin">R$ {{ formatMoney(s.value) }}</td>
                                    <td>
                                        <template v-if="isAdmin">
                                            <button class="btn btn-sm btn-warning mr-1" @click="openServiceModal(s)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" @click="deleteService(s)"><i class="fas fa-trash"></i></button>
                                        </template>
                                        <span v-else class="text-muted">-</span>
                                    </td>
                                </tr>
                                <tr v-if="services.items.length === 0">
                                    <td :colspan="isAdmin ? 4 : 3" class="text-center text-muted p-4">Nenhum serviço encontrado.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Página {{ services.page }} de {{ services.lastPage }}
                                </div>
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item" :class="{ disabled: services.page <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="fetchServices(services.page - 1)">«</a>
                                    </li>
                                    <li v-for="p in pageWindow(services.page, services.lastPage)" :key="'sp'+p" class="page-item" :class="{ active: p === services.page }">
                                        <a class="page-link" href="#" @click.prevent="fetchServices(p)">{{ p }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: services.page >= services.lastPage }">
                                        <a class="page-link" href="#" @click.prevent="fetchServices(services.page + 1)">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'company'" class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <b>Empresa prestadora</b>
                                <div class="text-muted" style="font-size: .9rem;">Logo, CNPJ e endereço completo</div>
                            </div>
                            <button class="btn btn-primary" @click="saveCompany" :disabled="isBusy || !isAdmin || companyHasErrors">
                                <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Salvando...</span>
                                <span v-else><i class="fas fa-save mr-1"></i> Salvar</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div v-if="!isAdmin" class="alert alert-warning mb-3">Somente administrador pode alterar os dados da empresa.</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome da empresa</label>
                                        <input v-model.trim="companyForm.name" class="form-control" :class="{ 'is-invalid': showCompanyError('name') }" @blur="touch('company','name')">
                                        <div v-if="showCompanyError('name')" class="invalid-feedback">{{ companyErrors.name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>CNPJ</label>
                                        <input :value="companyForm.cnpj" class="form-control" :class="{ 'is-invalid': showCompanyError('cnpj') }"
                                               @input="companyForm.cnpj = maskCpfCnpj($event.target.value); touch('company','cnpj')"
                                               @blur="onBlurCompanyCnpj">
                                        <div v-if="showCompanyError('cnpj')" class="invalid-feedback">{{ companyErrors.cnpj }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input :value="companyForm.phone" class="form-control" @input="companyForm.phone = maskPhone($event.target.value)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model.trim="companyForm.email" type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Logo (imagem)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="companyLogo" accept="image/*" @change="onCompanyLogoChange">
                                            <label class="custom-file-label" for="companyLogo">Escolher arquivo</label>
                                        </div>
                                        <div v-if="companyForm.logo_image" class="mt-2">
                                            <img :src="companyForm.logo_image" alt="Logo" class="img-fluid" style="max-height: 90px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input :value="companyForm.zip" class="form-control" :class="{ 'is-invalid': showCompanyError('zip') }"
                                               @input="companyForm.zip = maskZip($event.target.value); touch('company','zip')"
                                               @blur="onBlurCep('company')">
                                        <div v-if="showCompanyError('zip')" class="invalid-feedback">{{ companyErrors.zip }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rua</label>
                                        <input v-model.trim="companyForm.street" class="form-control" :class="{ 'is-invalid': showCompanyError('street') }" @blur="touch('company','street')">
                                        <div v-if="showCompanyError('street')" class="invalid-feedback">{{ companyErrors.street }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Número</label>
                                        <input v-model.trim="companyForm.number" class="form-control" :class="{ 'is-invalid': showCompanyError('number') }" @blur="touch('company','number')">
                                        <div v-if="showCompanyError('number')" class="invalid-feedback">{{ companyErrors.number }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input v-model.trim="companyForm.complement" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input v-model.trim="companyForm.district" class="form-control" :class="{ 'is-invalid': showCompanyError('district') }" @blur="touch('company','district')">
                                        <div v-if="showCompanyError('district')" class="invalid-feedback">{{ companyErrors.district }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input v-model.trim="companyForm.city" class="form-control" :class="{ 'is-invalid': showCompanyError('city') }" @blur="touch('company','city')">
                                        <div v-if="showCompanyError('city')" class="invalid-feedback">{{ companyErrors.city }}</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>UF</label>
                                        <input :value="companyForm.state" class="form-control" maxlength="2" :class="{ 'is-invalid': showCompanyError('state') }"
                                               @input="companyForm.state = String($event.target.value || '').toUpperCase().slice(0,2); touch('company','state')">
                                        <div v-if="showCompanyError('state')" class="invalid-feedback">{{ companyErrors.state }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'email' && isAdmin" class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <b>Envio de e-mail</b>
                                <div class="text-muted" style="font-size: .9rem;">Configurações SMTP usadas ao finalizar uma OS</div>
                            </div>
                            <button class="btn btn-primary" @click="saveEmailSettings" :disabled="isBusy || emailSettingsHasErrors">
                                <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Salvando...</span>
                                <span v-else><i class="fas fa-save mr-1"></i> Salvar</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="emailEnabled" v-model="emailSettingsForm.enabled" @change="touch('email','enabled')">
                                <label class="custom-control-label" for="emailEnabled">Ativar envio de e-mail ao finalizar OS</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Servidor (host)</label>
                                        <input v-model.trim="emailSettingsForm.host" class="form-control" :class="{ 'is-invalid': showEmailError('host') }" @blur="touch('email','host')">
                                        <div v-if="showEmailError('host')" class="invalid-feedback">{{ emailSettingsErrors.host }}</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Porta</label>
                                        <input v-model="emailSettingsForm.port" type="number" min="1" max="65535" class="form-control" :class="{ 'is-invalid': showEmailError('port') }" @blur="touch('email','port')">
                                        <div v-if="showEmailError('port')" class="invalid-feedback">{{ emailSettingsErrors.port }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Criptografia</label>
                                        <select v-model="emailSettingsForm.encryption" class="form-control" @change="touch('email','encryption')">
                                            <option value="">Nenhuma</option>
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Usuário</label>
                                        <input v-model.trim="emailSettingsForm.username" class="form-control" @blur="touch('email','username')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input v-model="emailSettingsForm.password" type="password" class="form-control" :placeholder="emailSettingsForm.has_password ? 'Deixe em branco para manter' : ''" @blur="touch('email','password')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remetente (from_address)</label>
                                        <input v-model.trim="emailSettingsForm.from_address" type="email" class="form-control" :class="{ 'is-invalid': showEmailError('from_address') }" @blur="touch('email','from_address')">
                                        <div v-if="showEmailError('from_address')" class="invalid-feedback">{{ emailSettingsErrors.from_address }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome do remetente (from_name)</label>
                                        <input v-model.trim="emailSettingsForm.from_name" class="form-control" @blur="touch('email','from_name')">
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mb-0">
                                A senha não é exibida por segurança. Se a senha já estiver cadastrada, deixe o campo em branco para manter.
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'users' && isAdmin" class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="input-group" style="max-width: 420px;">
                                    <input v-model.trim="users.filters.q" class="form-control" placeholder="Buscar (nome, email)" @input="debouncedFetchUsers()">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" @click="fetchUsers(1)"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-primary" @click="openUserModal()"><i class="fas fa-plus"></i> Novo usuário</button>
                            </div>
                            <div class="mt-2" style="max-width: 220px;">
                                <select v-model="users.filters.role" class="form-control form-control-sm" @change="fetchUsers(1)">
                                    <option value="">Perfil (todos)</option>
                                    <option value="admin">Administrador</option>
                                    <option value="tecnico">Técnico</option>
                                    <option value="cliente">Cliente</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th style="width: 140px;">Perfil</th>
                                    <th>Vínculo</th>
                                    <th style="width: 130px;">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="u in users.items" :key="'u'+u.id">
                                    <td>{{ u.name }}</td>
                                    <td>{{ u.email }}</td>
                                    <td>
                                        <span class="badge badge-secondary" v-if="u.role === 'admin'">Administrador</span>
                                        <span class="badge badge-info" v-else-if="u.role === 'tecnico'">Técnico</span>
                                        <span class="badge badge-primary" v-else-if="u.role === 'cliente'">Cliente</span>
                                        <span v-else>{{ u.role }}</span>
                                    </td>
                                    <td>{{ u.client ? u.client.name : '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mr-1" @click="openUserModal(u)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" @click="deleteUser(u)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr v-if="users.items.length === 0">
                                    <td colspan="5" class="text-center text-muted p-4">Nenhum usuário encontrado.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Página {{ users.page }} de {{ users.lastPage }}
                                </div>
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item" :class="{ disabled: users.page <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="fetchUsers(users.page - 1)">«</a>
                                    </li>
                                    <li v-for="p in pageWindow(users.page, users.lastPage)" :key="'up'+p" class="page-item" :class="{ active: p === users.page }">
                                        <a class="page-link" href="#" @click.prevent="fetchUsers(p)">{{ p }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: users.page >= users.lastPage }">
                                        <a class="page-link" href="#" @click.prevent="fetchUsers(users.page + 1)">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentView === 'orders'" class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <input v-model.trim="orders.filters.q" class="form-control" placeholder="Busca (nº, cliente, doc, técnico)" @input="debouncedFetchOrders()">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <select v-model="orders.filters.status" class="form-control" @change="fetchOrders(1)">
                                        <option value="">Status (todos)</option>
                                        <option value="aberta">Aberta</option>
                                        <option value="em_andamento">Em andamento</option>
                                        <option value="finalizada">Finalizada</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2" v-if="!isClient">
                                    <select v-model="orders.filters.client_id" class="form-control" @change="fetchOrders(1)">
                                        <option value="">Cliente (todos)</option>
                                        <option v-for="c in clientsAll" :key="'oc'+c.id" :value="c.id">{{ c.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input v-model="orders.filters.from" type="date" class="form-control" @change="fetchOrders(1)">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input v-model="orders.filters.to" type="date" class="form-control" @change="fetchOrders(1)">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-default" @click="fetchOrders(1)"><i class="fas fa-sync"></i> Atualizar</button>
                                <button v-if="!isClient" class="btn btn-primary" @click="openOrderModal()"><i class="fas fa-plus"></i> Nova OS</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Cliente</th>
                                    <th>Técnico</th>
                                    <th>Status</th>
                                    <th>Abertura</th>
                                    <th class="d-none d-md-table-cell">Fechamento</th>
                                    <th v-if="isAdmin" class="d-none d-sm-table-cell">Total</th>
                                    <th style="width: 170px;">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="o in orders.items" :key="o.id">
                                    <td>{{ o.number }}</td>
                                    <td>{{ o.client ? o.client.name : '' }}</td>
                                    <td>{{ o.responsible ? o.responsible.name : '-' }}</td>
                                    <td>
                                        <span class="badge" :class="statusBadge(o.status)">{{ statusLabel(o.status) }}</span>
                                    </td>
                                    <td>{{ formatDateTime(o.opened_at) }}</td>
                                    <td class="d-none d-md-table-cell">{{ o.closed_at ? formatDateTime(o.closed_at) : '-' }}</td>
                                    <td v-if="isAdmin" class="d-none d-sm-table-cell">R$ {{ formatMoney(o.total_value) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info mr-1" @click="viewOrder(o)"><i class="fas fa-eye"></i></button>
                                        <button v-if="o.status === 'finalizada'" class="btn btn-sm btn-secondary mr-1" @click="downloadOrderPdf(o.id, o.number)"><i class="fas fa-file-pdf"></i></button>
                                        <button v-if="isAdmin" class="btn btn-sm btn-warning mr-1" @click="openOrderModal(o)"><i class="fas fa-edit"></i></button>
                                        <button v-if="!isClient && o.status !== 'finalizada' && o.status !== 'cancelada'" class="btn btn-sm btn-success mr-1" @click="openCloseOrderModal(o)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button v-if="isAdmin" class="btn btn-sm btn-danger" @click="deleteOrder(o)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr v-if="orders.items.length === 0">
                                    <td :colspan="isAdmin ? 8 : 7" class="text-center text-muted p-4">Nenhuma OS encontrada.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Página {{ orders.page }} de {{ orders.lastPage }}
                                </div>
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item" :class="{ disabled: orders.page <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="fetchOrders(orders.page - 1)">«</a>
                                    </li>
                                    <li v-for="p in pageWindow(orders.page, orders.lastPage)" :key="'op'+p" class="page-item" :class="{ active: p === orders.page }">
                                        <a class="page-link" href="#" @click.prevent="fetchOrders(p)">{{ p }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: orders.page >= orders.lastPage }">
                                        <a class="page-link" href="#" @click.prevent="fetchOrders(orders.page + 1)">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ clientForm.id ? 'Editar cliente' : 'Novo cliente' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input v-model.trim="clientForm.name" class="form-control" :class="{ 'is-invalid': showClientError('name') }" @blur="touch('client','name')" required>
                                <div v-if="showClientError('name')" class="invalid-feedback">{{ clientErrors.name }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CPF/CNPJ</label>
                                <input v-model.trim="clientForm.document" class="form-control" :class="{ 'is-invalid': showClientError('document') }"
                                       @input="clientForm.document = maskCpfCnpj(clientForm.document)" @blur="touch('client','document')" required>
                                <div v-if="showClientError('document')" class="invalid-feedback">{{ clientErrors.document }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input v-model.trim="clientForm.phone" class="form-control" :class="{ 'is-invalid': showClientError('phone') }"
                                       @input="clientForm.phone = maskPhone(clientForm.phone)" @blur="touch('client','phone')" required>
                                <div v-if="showClientError('phone')" class="invalid-feedback">{{ clientErrors.phone }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model.trim="clientForm.email" type="email" class="form-control" :class="{ 'is-invalid': showClientError('email') }" @blur="touch('client','email')" required>
                                <div v-if="showClientError('email')" class="invalid-feedback">{{ clientErrors.email }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CEP</label>
                                <input v-model.trim="clientForm.zip" class="form-control" :class="{ 'is-invalid': showClientError('zip') }"
                                       @input="clientForm.zip = maskZip(clientForm.zip)" @blur="onBlurCep('client')" required>
                                <div v-if="showClientError('zip')" class="invalid-feedback">{{ clientErrors.zip }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>UF</label>
                                <input v-model.trim="clientForm.state" class="form-control" maxlength="2" :class="{ 'is-invalid': showClientError('state') }"
                                       @input="clientForm.state = (clientForm.state || '').toUpperCase()" @blur="touch('client','state')" required>
                                <div v-if="showClientError('state')" class="invalid-feedback">{{ clientErrors.state }}</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Rua</label>
                                <input v-model.trim="clientForm.street" class="form-control" :class="{ 'is-invalid': showClientError('street') }" @blur="touch('client','street')" required>
                                <div v-if="showClientError('street')" class="invalid-feedback">{{ clientErrors.street }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número</label>
                                <input v-model.trim="clientForm.number" class="form-control" :class="{ 'is-invalid': showClientError('number') }" @blur="touch('client','number')" required>
                                <div v-if="showClientError('number')" class="invalid-feedback">{{ clientErrors.number }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bairro</label>
                                <input v-model.trim="clientForm.district" class="form-control" :class="{ 'is-invalid': showClientError('district') }" @blur="touch('client','district')" required>
                                <div v-if="showClientError('district')" class="invalid-feedback">{{ clientErrors.district }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input v-model.trim="clientForm.city" class="form-control" :class="{ 'is-invalid': showClientError('city') }" @blur="touch('client','city')" required>
                                <div v-if="showClientError('city')" class="invalid-feedback">{{ clientErrors.city }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Complemento</label>
                                <input v-model.trim="clientForm.complement" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div v-if="ui.modalError" class="alert alert-danger mb-0">{{ ui.modalError }}</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" @click="saveClient" :disabled="isBusy || clientHasErrors">
                        <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Salvando...</span>
                        <span v-else>Salvar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ serviceForm.id ? 'Editar serviço' : 'Novo serviço' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome do serviço</label>
                        <input v-model.trim="serviceForm.name" class="form-control" :class="{ 'is-invalid': showServiceError('name') }" @blur="touch('service','name')" required>
                        <div v-if="showServiceError('name')" class="invalid-feedback">{{ serviceErrors.name }}</div>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea v-model.trim="serviceForm.description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <input v-model.trim="serviceForm.value" class="form-control" :class="{ 'is-invalid': showServiceError('value') }"
                               @input="serviceForm.value = maskCurrency(serviceForm.value)" @blur="touch('service','value')" placeholder="R$ 0,00" required>
                        <div v-if="showServiceError('value')" class="invalid-feedback">{{ serviceErrors.value }}</div>
                    </div>
                    <div v-if="ui.modalError" class="alert alert-danger mb-0">{{ ui.modalError }}</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" @click="saveService" :disabled="isBusy || serviceHasErrors">
                        <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Salvando...</span>
                        <span v-else>Salvar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ userForm.id ? 'Editar usuário' : 'Novo usuário' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input v-model.trim="userForm.name" class="form-control" :class="{ 'is-invalid': showUserError('name') }" @blur="touch('user','name')">
                                <div v-if="showUserError('name')" class="invalid-feedback">{{ userErrors.name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model.trim="userForm.email" type="email" class="form-control" :class="{ 'is-invalid': showUserError('email') }" @blur="touch('user','email')">
                                <div v-if="showUserError('email')" class="invalid-feedback">{{ userErrors.email }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Perfil</label>
                                <select v-model="userForm.role" class="form-control" :class="{ 'is-invalid': showUserError('role') }" @change="touch('user','role')">
                                    <option value="admin">Administrador</option>
                                    <option value="tecnico">Técnico</option>
                                    <option value="cliente">Cliente</option>
                                </select>
                                <div v-if="showUserError('role')" class="invalid-feedback">{{ userErrors.role }}</div>
                            </div>
                        </div>
                        <div class="col-md-8" v-if="userForm.role === 'cliente'">
                            <div class="form-group">
                                <label>Cliente vinculado</label>
                                <select v-model="userForm.client_id" class="form-control" :class="{ 'is-invalid': showUserError('client_id') }" @blur="touch('user','client_id')">
                                    <option value="" disabled>Selecione</option>
                                    <option v-for="c in clientsAll" :key="'uc'+c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                                <div v-if="showUserError('client_id')" class="invalid-feedback">{{ userErrors.client_id }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha</label>
                                <input v-model="userForm.password" type="password" class="form-control" :class="{ 'is-invalid': showUserError('password') }" @blur="touch('user','password')" :placeholder="userForm.id ? '(manter atual)' : ''">
                                <div v-if="showUserError('password')" class="invalid-feedback">{{ userErrors.password }}</div>
                            </div>
                        </div>
                    </div>
                    <div v-if="ui.modalError" class="alert alert-danger mb-0">{{ ui.modalError }}</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" @click="saveUser" :disabled="isBusy || userHasErrors">
                        <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Salvando...</span>
                        <span v-else>Salvar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ orderCloseMode ? ('Fechar OS #' + orderForm.number) : (orderForm.id ? 'Editar OS #' + orderForm.number : 'Nova OS') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select v-model="orderForm.client_id" class="form-control" :class="{ 'is-invalid': showOrderError('client_id') }" @blur="touch('order','client_id')" :disabled="orderCloseMode" required>
                                    <option value="" disabled>Selecione</option>
                                    <option v-for="c in clientsAll" :key="'cc'+c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                                <div v-if="showOrderError('client_id')" class="invalid-feedback">{{ orderErrors.client_id }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select v-model="orderForm.status" class="form-control" :disabled="orderCloseMode" required>
                                    <option value="aberta">Aberta</option>
                                    <option value="em_andamento">Em andamento</option>
                                    <option value="finalizada">Finalizada</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data de abertura</label>
                                <input v-model="orderForm.opened_at" type="datetime-local" class="form-control" :disabled="orderCloseMode">
                            </div>
                        </div>
                        <div class="col-md-2" v-if="isAdmin">
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control" :value="'R$ ' + formatMoney(orderForm.total_preview)" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observações</label>
                                <textarea v-model.trim="orderForm.notes" class="form-control" rows="2" :disabled="orderCloseMode"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="orderForm.id">
                            <div class="form-group">
                                <label>Solução</label>
                                <textarea v-model.trim="orderForm.solution" class="form-control" rows="2" :class="{ 'is-invalid': showOrderError('solution') }" @blur="touch('order','solution')" placeholder="Obrigatório ao finalizar a OS"></textarea>
                                <div v-if="showOrderError('solution')" class="invalid-feedback">{{ orderErrors.solution }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="isAdmin">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsável (técnico)</label>
                                <select v-model="orderForm.responsible_user_id" class="form-control" :disabled="orderCloseMode">
                                    <option value="">Não definido</option>
                                    <option v-for="u in techniciansAll" :key="'tu'+u.id" :value="u.id">{{ u.name }} ({{ u.email }})</option>
                                </select>
                                <div class="text-muted" style="font-size: .85rem;">Somente o técnico responsável verá esta OS no perfil técnico.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card" v-if="orderForm.id">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>Assinatura do solicitante</b>
                            <button class="btn btn-sm btn-primary" @click="openSignatureModal" :disabled="!canSignOrder">
                                <i class="fas fa-pen-nib mr-1"></i> Assinar e finalizar
                            </button>
                        </div>
                        <div class="card-body">
                            <div v-if="orderForm.signature_image" class="text-center">
                                <img :src="orderForm.signature_image" alt="Assinatura" class="img-fluid" style="max-height: 200px;">
                                <div class="text-muted mt-2" style="font-size: 0.9rem;">Assinatura capturada</div>
                            </div>
                            <div v-else class="text-muted">
                                Para finalizar a OS, é necessário coletar a assinatura.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header">
                            <b>Serviços</b>
                        </div>
                        <div class="card-body p-0">
                            <div class="p-3" v-if="!orderCloseMode">
                                <div class="input-group">
                                    <input v-model.trim="orderServiceSearch" class="form-control" placeholder="Buscar serviço cadastrado (nome)" :disabled="servicesAll.length === 0">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" @click="orderServiceSearch = ''" :disabled="!orderServiceSearch"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div v-if="servicesAll.length === 0" class="text-muted mt-2">Cadastre serviços para criar uma OS.</div>
                                <div v-else-if="orderServiceSearch && serviceSearchResults.length === 0" class="text-muted mt-2">Nenhum serviço encontrado.</div>
                                <div v-else-if="orderServiceSearch && serviceSearchResults.length" class="list-group mt-2">
                                    <a v-for="s in serviceSearchResults" :key="'sr'+s.id" href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       @click.prevent="addServiceToOrder(s)">
                                        <span>{{ s.name }}</span>
                                        <span class="badge badge-primary badge-pill">Adicionar</span>
                                    </a>
                                </div>
                            </div>

                            <div v-if="orderForm.selected && orderForm.selected.length" class="table-responsive p-0">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th style="width: 120px;">Qtd</th>
                                        <th v-if="isAdmin" style="width: 120px;">Valor</th>
                                        <th v-if="isAdmin" style="width: 140px;">Subtotal</th>
                                        <th style="width: 70px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="sid in orderForm.selected" :key="'sel'+sid">
                                        <td>{{ serviceById(sid) ? serviceById(sid).name : sid }}</td>
                                        <td>
                                            <input type="number" min="1" class="form-control form-control-sm"
                                                   v-model.number="orderForm.quantities[sid]"
                                                   :disabled="orderCloseMode"
                                                   @input="recalcOrderTotal">
                                        </td>
                                        <td v-if="isAdmin">R$ {{ formatMoney(serviceById(sid) ? serviceById(sid).value : 0) }}</td>
                                        <td v-if="isAdmin">R$ {{ formatMoney(lineTotalPreview(sid, serviceById(sid) ? serviceById(sid).value : 0)) }}</td>
                                        <td class="text-right">
                                            <button v-if="!orderCloseMode" class="btn btn-sm btn-danger" @click="removeServiceFromOrder(sid)"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="text-center text-muted p-4">Pesquise e adicione serviços.</div>
                        </div>
                    </div>
                    <div v-if="showOrderError('services')" class="text-danger mt-2" style="font-size: 0.9rem;">
                        {{ orderErrors.services }}
                    </div>
                    <div v-if="ui.modalError" class="alert alert-danger mt-3 mb-0">{{ ui.modalError }}</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" @click="orderCloseMode ? openSignatureModal() : saveOrder()" :disabled="isBusy || (orderCloseMode ? false : orderHasErrors)">
                        <span v-if="isBusy"><i class="fas fa-spinner fa-spin mr-1"></i> Processando...</span>
                        <span v-else>{{ orderCloseMode ? 'Fechar OS' : 'Salvar' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderViewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">OS #{{ orderView.number }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cliente</label>
                                <input class="form-control" :value="orderView.client ? orderView.client.name : ''" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <input class="form-control" :value="statusLabel(orderView.status)" disabled>
                            </div>
                        </div>
                            <div class="col-md-3" v-if="isAdmin">
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control" :value="'R$ ' + formatMoney(orderView.total_value)" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Abertura</label>
                                <input class="form-control" :value="formatDateTime(orderView.opened_at)" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fechamento</label>
                                <input class="form-control" :value="orderView.closed_at ? formatDateTime(orderView.closed_at) : '-'" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observações</label>
                                <textarea class="form-control" rows="2" :value="orderView.notes || ''" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="orderView.solution">
                            <div class="form-group">
                                <label>Solução</label>
                                <textarea class="form-control" rows="2" :value="orderView.solution" disabled></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header"><b>Serviços</b></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th style="width: 90px;">Qtd</th>
                                    <th v-if="isAdmin" style="width: 120px;">Unitário</th>
                                    <th v-if="isAdmin" style="width: 120px;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="s in orderView.services" :key="'ov'+s.id">
                                    <td>{{ s.name }}</td>
                                    <td>{{ s.pivot.quantity }}</td>
                                    <td v-if="isAdmin">R$ {{ formatMoney(s.pivot.unit_value) }}</td>
                                    <td v-if="isAdmin">R$ {{ formatMoney(Number(s.pivot.unit_value) * Number(s.pivot.quantity)) }}</td>
                                </tr>
                                <tr v-if="!orderView.services || orderView.services.length === 0">
                                    <td :colspan="isAdmin ? 4 : 2" class="text-center text-muted p-4">Sem serviços.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-if="orderView.signature_image" class="card mt-3 mb-0">
                        <div class="card-header"><b>Assinatura</b></div>
                        <div class="card-body text-center">
                            <img :src="orderView.signature_image" alt="Assinatura" class="img-fluid" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assinatura para finalizar OS #{{ orderForm.number || '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="signatureRoot"></div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-default" @click="resetSignature"><i class="fas fa-undo mr-1"></i> Limpar</button>
                        <button class="btn btn-success" @click="saveSignature"><i class="fas fa-check mr-1"></i> Confirmar assinatura</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endverbatim
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.11.0/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@lemonadejs/signature/dist/index.min.js"></script>

<script>
const { createApp } = Vue;

// Frontend SPA-like (sem build): Vue 3 + Axios via CDN.
// Navegação por hash (#/dashboard, #/clients, ...) e filtros sem reload de página.
createApp({
    data() {
        return {
            auth: {
                token: localStorage.getItem('os_token') || '',
                user: null,
            },
            currentView: 'dashboard',
            ui: {
                loading: false,
                loadingCount: 0,
                alert: '',
                notice: '',
                modalError: '',
            },
            loginForm: {
                email: 'test@example.com',
                password: 'password',
            },
            dashboard: {
                open: 0,
                finalized: 0,
                revenue_total: 0,
            },
            company: null,
            clients: {
                items: [],
                page: 1,
                lastPage: 1,
                filters: { q: '' },
            },
            services: {
                items: [],
                page: 1,
                lastPage: 1,
                filters: { q: '' },
            },
            orders: {
                items: [],
                page: 1,
                lastPage: 1,
                filters: { q: '', status: '', client_id: '', from: '', to: '' },
            },
            users: {
                items: [],
                page: 1,
                lastPage: 1,
                filters: { q: '', role: '' },
            },
            clientsAll: [],
            servicesAll: [],
            techniciansAll: [],
            companyForm: this.emptyCompany(),
            emailSettingsForm: this.emptyEmailSettings(),
            userForm: this.emptyUser(),
            clientForm: this.emptyClient(),
            serviceForm: this.emptyService(),
            orderForm: this.emptyOrder(),
            orderServiceSearch: '',
            orderCloseMode: false,
            orderView: { services: [] },
            signatureComponent: null,
            touched: {
                company: {},
                email: {},
                user: {},
                client: {},
                service: {},
                order: {},
            },
            timers: {
                clients: null,
                services: null,
                orders: null,
                users: null,
            }
        };
    },
    computed: {
        isBusy() {
            return this.ui.loading || this.ui.loadingCount > 0;
        },
        roleValue() {
            return this.auth.user && this.auth.user.role ? this.auth.user.role : 'admin';
        },
        isAdmin() {
            return this.roleValue === 'admin';
        },
        isClient() {
            return this.roleValue === 'cliente';
        },
        isTechnician() {
            return this.roleValue === 'tecnico';
        },
        titleForView() {
            if (this.currentView === 'clients') return 'Clientes';
            if (this.currentView === 'services') return 'Serviços';
            if (this.currentView === 'company') return 'Empresa';
            if (this.currentView === 'email') return 'Configuração de Email';
            if (this.currentView === 'users') return 'Usuários';
            if (this.currentView === 'orders') return 'Ordens de Serviço';
            return 'Dashboard';
        },
        breadcrumbs() {
            if (!this.auth.token) return [];
            const items = this.isAdmin
                ? [{ text: 'Dashboard', href: '#/dashboard' }]
                : [{ text: 'Ordens de Serviço', href: '#/orders' }];

            if (this.isAdmin && this.currentView !== 'dashboard') {
                items.push({ text: this.titleForView, href: `#/${this.currentView}` });
                return items;
            }
            if (!this.isAdmin && this.currentView !== 'orders') {
                items.push({ text: this.titleForView, href: `#/${this.currentView}` });
            }

            return items;
        },
        clientErrors() {
            const f = this.clientForm || {};
            const errors = {};

            if (!String(f.name || '').trim()) errors.name = 'Nome é obrigatório.';

            const docDigits = this.digitsOnly(f.document || '');
            if (!docDigits) errors.document = 'CPF/CNPJ é obrigatório.';
            else if (!/^\d{11}$/.test(docDigits) && !/^\d{14}$/.test(docDigits)) errors.document = 'CPF/CNPJ inválido.';

            const phoneDigits = this.digitsOnly(f.phone || '');
            if (!phoneDigits) errors.phone = 'Telefone é obrigatório.';
            else if (phoneDigits.length < 10) errors.phone = 'Telefone inválido.';

            const email = String(f.email || '').trim();
            if (!email) errors.email = 'Email é obrigatório.';
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.email = 'Email inválido.';

            const zipDigits = this.digitsOnly(f.zip || '');
            if (!zipDigits) errors.zip = 'CEP é obrigatório.';
            else if (zipDigits.length !== 8) errors.zip = 'CEP inválido.';

            if (!String(f.state || '').trim()) errors.state = 'UF é obrigatório.';
            else if (String(f.state || '').trim().length !== 2) errors.state = 'UF deve ter 2 letras.';

            if (!String(f.street || '').trim()) errors.street = 'Rua é obrigatória.';
            if (!String(f.number || '').trim()) errors.number = 'Número é obrigatório.';
            if (!String(f.district || '').trim()) errors.district = 'Bairro é obrigatório.';
            if (!String(f.city || '').trim()) errors.city = 'Cidade é obrigatória.';

            return errors;
        },
        clientHasErrors() {
            return Object.keys(this.clientErrors).length > 0;
        },
        serviceErrors() {
            const f = this.serviceForm || {};
            const errors = {};

            if (!String(f.name || '').trim()) errors.name = 'Nome do serviço é obrigatório.';

            const raw = String(f.value || '').trim();
            if (!raw) errors.value = 'Valor é obrigatório.';
            else {
                const parsed = this.parseCurrency(raw);
                if (Number.isNaN(parsed) || parsed < 0) errors.value = 'Valor inválido.';
            }

            return errors;
        },
        serviceHasErrors() {
            return Object.keys(this.serviceErrors).length > 0;
        },
        companyErrors() {
            const f = this.companyForm || {};
            const errors = {};

            if (!String(f.name || '').trim()) errors.name = 'Nome é obrigatório.';

            const cnpj = this.digitsOnly(f.cnpj || '');
            if (!cnpj) errors.cnpj = 'CNPJ é obrigatório.';
            else if (!/^\d{14}$/.test(cnpj)) errors.cnpj = 'CNPJ inválido.';

            const zipDigits = this.digitsOnly(f.zip || '');
            if (!zipDigits) errors.zip = 'CEP é obrigatório.';
            else if (zipDigits.length !== 8) errors.zip = 'CEP inválido.';

            if (!String(f.street || '').trim()) errors.street = 'Rua é obrigatória.';
            if (!String(f.number || '').trim()) errors.number = 'Número é obrigatório.';
            if (!String(f.district || '').trim()) errors.district = 'Bairro é obrigatório.';
            if (!String(f.city || '').trim()) errors.city = 'Cidade é obrigatória.';

            if (!String(f.state || '').trim()) errors.state = 'UF é obrigatório.';
            else if (String(f.state || '').trim().length !== 2) errors.state = 'UF deve ter 2 letras.';

            return errors;
        },
        companyHasErrors() {
            return Object.keys(this.companyErrors).length > 0;
        },
        emailSettingsErrors() {
            const f = this.emailSettingsForm || {};
            const errors = {};
            const enabled = Boolean(f.enabled);

            if (enabled) {
                if (!String(f.host || '').trim()) errors.host = 'Host é obrigatório.';

                const rawPort = String(f.port || '').trim();
                const port = rawPort ? parseInt(rawPort, 10) : NaN;
                if (!rawPort) errors.port = 'Porta é obrigatória.';
                else if (Number.isNaN(port) || port < 1 || port > 65535) errors.port = 'Porta inválida.';

                const from = String(f.from_address || '').trim();
                if (!from) errors.from_address = 'Remetente (from_address) é obrigatório.';
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(from)) errors.from_address = 'Email inválido.';
            }

            const enc = String(f.encryption || '').trim().toLowerCase();
            if (enc && enc !== 'tls' && enc !== 'ssl') errors.encryption = 'Criptografia inválida.';

            return errors;
        },
        emailSettingsHasErrors() {
            return Object.keys(this.emailSettingsErrors).length > 0;
        },
        userErrors() {
            const f = this.userForm || {};
            const errors = {};

            if (!String(f.name || '').trim()) errors.name = 'Nome é obrigatório.';

            const email = String(f.email || '').trim();
            if (!email) errors.email = 'Email é obrigatório.';
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.email = 'Email inválido.';

            if (!String(f.role || '').trim()) errors.role = 'Perfil é obrigatório.';

            if (String(f.role || '') === 'cliente' && !f.client_id) errors.client_id = 'Selecione o cliente vinculado.';

            const pwd = String(f.password || '');
            if (!f.id && !pwd) errors.password = 'Senha é obrigatória.';
            if (pwd && pwd.length < 6) errors.password = 'Senha deve ter ao menos 6 caracteres.';

            return errors;
        },
        userHasErrors() {
            return Object.keys(this.userErrors).length > 0;
        },
        orderErrors() {
            const f = this.orderForm || {};
            const errors = {};

            if (!f.client_id) errors.client_id = 'Cliente é obrigatório.';
            if (!f.selected || f.selected.length === 0) errors.services = 'Adicione ao menos um serviço.';
            if (f.status === 'finalizada' && !String(f.signature_image || '').trim()) errors.signature_image = 'Assinatura é obrigatória para finalizar a OS.';
            if (f.status === 'finalizada' && !String(f.solution || '').trim()) errors.solution = 'Solução é obrigatória para finalizar a OS.';

            return errors;
        },
        orderHasErrors() {
            return Object.keys(this.orderErrors).length > 0;
        },
        canSignOrder() {
            return !this.isClient && Boolean(this.orderForm.id) && this.orderForm.status !== 'finalizada' && this.orderForm.status !== 'cancelada';
        },
        serviceSearchResults() {
            const q = String(this.orderServiceSearch || '').trim().toLowerCase();
            if (!q) return [];
            const selected = this.orderForm && this.orderForm.selected ? this.orderForm.selected : [];
            return (this.servicesAll || [])
                .filter((s) => String(s.name || '').toLowerCase().includes(q))
                .filter((s) => !selected.includes(s.id))
                .slice(0, 8);
        }
    },
    methods: {
        // Wrapper para exibir loading global em requisições de listagens/dashboard (pode haver múltiplas simultâneas).
        async withPageLoading(fn) {
            this.ui.loadingCount += 1;
            try {
                return await fn();
            } finally {
                this.ui.loadingCount = Math.max(0, this.ui.loadingCount - 1);
            }
        },
        emptyCompany() {
            return {
                id: null,
                name: '',
                cnpj: '',
                logo_image: '',
                zip: '',
                street: '',
                number: '',
                complement: '',
                district: '',
                city: '',
                state: '',
                phone: '',
                email: '',
            };
        },
        emptyEmailSettings() {
            return {
                id: null,
                enabled: false,
                mailer: 'smtp',
                host: '',
                port: 587,
                username: '',
                password: '',
                encryption: 'tls',
                from_address: '',
                from_name: '',
                has_password: false,
            };
        },
        emptyUser() {
            return {
                id: null,
                name: '',
                email: '',
                role: 'tecnico',
                client_id: '',
                password: '',
            };
        },
        emptyClient() {
            return {
                id: null,
                name: '',
                document: '',
                phone: '',
                email: '',
                zip: '',
                street: '',
                number: '',
                complement: '',
                district: '',
                city: '',
                state: '',
            };
        },
        emptyService() {
            return { id: null, name: '', description: '', value: '' };
        },
        emptyOrder() {
            return {
                id: null,
                number: null,
                client_id: '',
                responsible_user_id: '',
                status: 'aberta',
                original_status: null,
                opened_at: '',
                notes: '',
                solution: '',
                signature_image: '',
                selected: [],
                quantities: {},
                total_preview: 0,
            };
        },
        digitsOnly(value) {
            return String(value || '').replace(/\D+/g, '');
        },
        touch(scope, field) {
            if (!this.touched[scope]) this.touched[scope] = {};
            this.touched[scope][field] = true;
        },
        touchAll(scope) {
            if (scope === 'company') {
                Object.keys(this.companyErrors).forEach((k) => this.touch('company', k));
            }
            if (scope === 'email') {
                Object.keys(this.emailSettingsErrors).forEach((k) => this.touch('email', k));
            }
            if (scope === 'user') {
                Object.keys(this.userErrors).forEach((k) => this.touch('user', k));
            }
            if (scope === 'client') {
                Object.keys(this.clientErrors).forEach((k) => this.touch('client', k));
            }
            if (scope === 'service') {
                Object.keys(this.serviceErrors).forEach((k) => this.touch('service', k));
            }
            if (scope === 'order') {
                Object.keys(this.orderErrors).forEach((k) => this.touch('order', k));
            }
        },
        showCompanyError(field) {
            return Boolean(this.touched.company && this.touched.company[field] && this.companyErrors[field]);
        },
        showEmailError(field) {
            return Boolean(this.touched.email && this.touched.email[field] && this.emailSettingsErrors[field]);
        },
        showUserError(field) {
            return Boolean(this.touched.user && this.touched.user[field] && this.userErrors[field]);
        },
        showClientError(field) {
            return Boolean(this.touched.client && this.touched.client[field] && this.clientErrors[field]);
        },
        showServiceError(field) {
            return Boolean(this.touched.service && this.touched.service[field] && this.serviceErrors[field]);
        },
        showOrderError(field) {
            return Boolean(this.touched.order && this.touched.order[field] && this.orderErrors[field]);
        },
        maskCpfCnpj(value) {
            const digits = this.digitsOnly(value);
            if (!digits) return '';

            if (digits.length <= 11) {
                const d = digits.slice(0, 11);
                return d
                    .replace(/^(\d{3})(\d)/, '$1.$2')
                    .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
                    .replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})$/, '$1.$2.$3-$4');
            }

            const d = digits.slice(0, 14);
            return d
                .replace(/^(\d{2})(\d)/, '$1.$2')
                .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                .replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4')
                .replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d{1,2})$/, '$1.$2.$3/$4-$5');
        },
        maskPhone(value) {
            const digits = this.digitsOnly(value).slice(0, 11);
            if (!digits) return '';

            const ddd = digits.slice(0, 2);
            const rest = digits.slice(2);

            if (rest.length <= 4) return `(${ddd}) ${rest}`;
            if (rest.length <= 8) return `(${ddd}) ${rest.slice(0, 4)}-${rest.slice(4)}`;
            return `(${ddd}) ${rest.slice(0, 5)}-${rest.slice(5)}`;
        },
        maskZip(value) {
            const digits = this.digitsOnly(value).slice(0, 8);
            if (!digits) return '';
            if (digits.length <= 5) return digits;
            return `${digits.slice(0, 5)}-${digits.slice(5)}`;
        },
        onBlurCep(scope) {
            this.touch(scope, 'zip');
            const form = scope === 'company' ? this.companyForm : this.clientForm;
            const cep = this.digitsOnly(form.zip || '');
            if (cep.length !== 8) return;
            this.fillAddressFromCep(scope, cep, true);
        },
        async fillAddressFromCep(scope, cepDigits, onlyIfEmpty = false) {
            return await this.withPageLoading(async () => {
                try {
                    const resp = await axios.get(`https://viacep.com.br/ws/${cepDigits}/json/`, { timeout: 12000 });
                    const data = resp.data || {};
                    if (data.erro) {
                        this.setAlert('CEP não encontrado.');
                        return;
                    }

                    const form = scope === 'company' ? this.companyForm : this.clientForm;

                    const street = String(data.logradouro || '').trim();
                    const district = String(data.bairro || '').trim();
                    const city = String(data.localidade || '').trim();
                    const state = String(data.uf || '').trim();
                    const complement = String(data.complemento || '').trim();

                    if (!onlyIfEmpty || !String(form.street || '').trim()) form.street = street || form.street;
                    if (!onlyIfEmpty || !String(form.district || '').trim()) form.district = district || form.district;
                    if (!onlyIfEmpty || !String(form.city || '').trim()) form.city = city || form.city;
                    if (!onlyIfEmpty || !String(form.state || '').trim()) form.state = state || form.state;
                    if (complement && !String(form.complement || '').trim()) form.complement = complement;

                    form.zip = this.maskZip(cepDigits);
                    if (form.state) form.state = String(form.state).toUpperCase();
                } catch (e) {
                    this.setAlert('Não foi possível consultar o CEP.');
                }
            });
        },
        onBlurCompanyCnpj() {
            this.touch('company', 'cnpj');
            const cnpj = this.digitsOnly(this.companyForm.cnpj || '');
            if (cnpj.length !== 14) return;
            this.fillCompanyFromCnpj(cnpj);
        },
        async fillCompanyFromCnpj(cnpjDigits) {
            return await this.withPageLoading(async () => {
                try {
                    const resp = await axios.get(`https://brasilapi.com.br/api/cnpj/v1/${cnpjDigits}`, { timeout: 15000 });
                    const d = resp.data || {};

                    const name = String(d.nome_fantasia || d.razao_social || '').trim();
                    if (name) this.companyForm.name = name;

                    const phoneRaw = String(d.ddd_telefone_1 || d.ddd_telefone_2 || '').trim();
                    if (phoneRaw) this.companyForm.phone = this.maskPhone(phoneRaw);

                    const cep = this.digitsOnly(d.cep || '');
                    if (cep.length === 8) this.companyForm.zip = this.maskZip(cep);

                    if (d.logradouro) this.companyForm.street = d.logradouro;
                    if (d.numero) this.companyForm.number = String(d.numero);
                    if (d.complemento && !String(this.companyForm.complement || '').trim()) this.companyForm.complement = d.complemento;
                    if (d.bairro) this.companyForm.district = d.bairro;
                    if (d.municipio) this.companyForm.city = d.municipio;
                    if (d.uf) this.companyForm.state = String(d.uf).toUpperCase();

                    const currentCep = this.digitsOnly(this.companyForm.zip || '');
                    if (currentCep.length === 8) {
                        await this.fillAddressFromCep('company', currentCep, true);
                    }
                } catch (e) {
                    this.setAlert('Não foi possível consultar o CNPJ.');
                }
            });
        },
        maskCurrency(value) {
            const digits = this.digitsOnly(value);
            if (!digits) return '';

            const cents = digits.slice(-2).padStart(2, '0');
            const intRaw = digits.slice(0, -2) || '0';
            const int = intRaw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            return `R$ ${int},${cents}`;
        },
        parseCurrency(value) {
            const digits = this.digitsOnly(value);
            if (!digits) return NaN;
            const cents = digits.slice(-2).padStart(2, '0');
            const int = digits.slice(0, -2) || '0';
            return Number(`${int}.${cents}`);
        },
        currencyToInput(value) {
            const n = Number(value || 0);
            const normalized = Math.round(n * 100);
            return this.maskCurrency(String(normalized).padStart(3, '0'));
        },
        openSignatureModal() {
            if (!this.ensureLemonadeSignatureAvailable()) {
                this.setAlert('Componente de assinatura não carregado.');
                return;
            }

            if (!this.canSignOrder) {
                this.setAlert('Só é possível assinar para finalizar uma OS em andamento/aberta.');
                return;
            }

            if (!String(this.orderForm.solution || '').trim()) {
                this.setAlert('Preencha a solução antes de coletar a assinatura.');
                return;
            }

            $('#signatureModal').modal('show');

            this.$nextTick(() => {
                const root = document.getElementById('signatureRoot');
                if (!root) return;

                root.innerHTML = '';

                this.signatureComponent = Signature(root, {
                    width: root.clientWidth ? Math.min(root.clientWidth, 700) : 700,
                    height: 180,
                    value: [],
                    instructions: 'Assine para confirmar a finalização da OS',
                });
            });
        },
        resetSignature() {
            if (this.signatureComponent) {
                this.signatureComponent.value = [];
            }
        },
        saveSignature() {
            if (!this.signatureComponent) {
                this.setAlert('Assinatura não iniciada.');
                return;
            }

            const image = this.signatureComponent.getImage();
            if (!image || typeof image !== 'string' || image.length < 50) {
                this.setAlert('Assine antes de confirmar.');
                return;
            }

            this.orderForm.signature_image = image;
            this.orderForm.status = 'finalizada';
            this.touch('order', 'signature_image');
            $('#signatureModal').modal('hide');
            if (this.isClient) {
                this.finalizeOrderWithSignature(this.orderForm.id, this.orderForm.number, image);
            } else if (this.orderCloseMode) {
                this.setNotice('Assinatura capturada. Fechando OS...');
                this.saveOrder();
            } else {
                this.setNotice('Assinatura salva na OS.');
            }
        },
        setAuthHeader() {
            if (this.auth.token) {
                axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`;
            } else {
                delete axios.defaults.headers.common.Authorization;
            }
        },
        toast(type, message, title = '') {
            const map = {
                success: { klass: 'bg-success', title: 'Sucesso' },
                error: { klass: 'bg-danger', title: 'Erro' },
                warning: { klass: 'bg-warning', title: 'Atenção' },
                info: { klass: 'bg-info', title: 'Info' },
            };

            const cfg = map[type] || map.info;
            const toastTitle = title || cfg.title;

            if (window.jQuery && jQuery(document).Toasts) {
                jQuery(document).Toasts('create', {
                    class: cfg.klass,
                    title: toastTitle,
                    body: message,
                    autohide: true,
                    delay: 3000,
                });
            }
        },
        ensureLemonadeSignatureAvailable() {
            return typeof window.Signature === 'function';
        },
        setNotice(msg) {
            this.ui.notice = msg;
            setTimeout(() => { this.ui.notice = ''; }, 3000);
            this.toast('success', msg);
        },
        setAlert(msg) {
            this.ui.alert = msg;
            this.toast('error', msg);
        },
        setModalError(msg) {
            this.ui.modalError = msg;
        },
        formatMoney(value) {
            const n = Number(value || 0);
            return n.toFixed(2).replace('.', ',');
        },
        formatDateTime(value) {
            if (!value) return '';
            const d = new Date(value);
            if (Number.isNaN(d.getTime())) return value;
            const pad = (x) => String(x).padStart(2, '0');
            return `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
        },
        toDatetimeLocal(value) {
            if (!value) return '';
            const d = new Date(value);
            const pad = (x) => String(x).padStart(2, '0');
            return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
        },
        statusLabel(s) {
            if (s === 'aberta') return 'Aberta';
            if (s === 'em_andamento') return 'Em andamento';
            if (s === 'finalizada') return 'Finalizada';
            if (s === 'cancelada') return 'Cancelada';
            return s || '-';
        },
        statusBadge(s) {
            if (s === 'aberta') return 'badge-info';
            if (s === 'em_andamento') return 'badge-warning';
            if (s === 'finalizada') return 'badge-success';
            if (s === 'cancelada') return 'badge-danger';
            return 'badge-secondary';
        },
        pageWindow(current, last) {
            const max = 5;
            const pages = [];
            const start = Math.max(1, current - 2);
            const end = Math.min(last, start + max - 1);
            const adjustedStart = Math.max(1, end - max + 1);
            for (let p = adjustedStart; p <= end; p += 1) pages.push(p);
            return pages;
        },
        apiErrorMessage(err) {
            if (err && err.response && err.response.data && err.response.data.message) return err.response.data.message;
            if (err && err.response && err.response.data && err.response.data.errors) {
                const firstKey = Object.keys(err.response.data.errors)[0];
                const firstArr = err.response.data.errors[firstKey];
                return (firstArr && firstArr[0]) || 'Erro de validação.';
            }
            return 'Erro ao processar a requisição.';
        },
        async login() {
            this.ui.loading = true;
            this.ui.alert = '';
            try {
                const resp = await axios.post('/api/auth/login', this.loginForm);
                this.auth.token = resp.data.token;
                this.auth.user = resp.data.user;
                localStorage.setItem('os_token', this.auth.token);
                this.setAuthHeader();
                await this.bootstrapData();
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async logout() {
            this.ui.loading = true;
            try {
                await axios.post('/api/auth/logout');
            } catch (e) {
            } finally {
                this.auth.token = '';
                this.auth.user = null;
                localStorage.removeItem('os_token');
                this.setAuthHeader();
                this.ui.loading = false;
                this.currentView = 'dashboard';
                location.hash = '#/dashboard';
            }
        },
        async loadMe() {
            if (!this.auth.token) return;
            this.setAuthHeader();
            try {
                const resp = await axios.get('/api/auth/me');
                this.auth.user = resp.data;
            } catch (e) {
                await this.logout();
            }
        },
        async fetchDashboard() {
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/dashboard');
                this.dashboard = resp.data;
            });
        },
        async fetchCompany() {
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/company');
                this.company = resp.data;
                const data = resp.data || {};
                this.companyForm = { ...this.emptyCompany(), ...data };
                this.companyForm.cnpj = this.maskCpfCnpj(this.companyForm.cnpj);
                this.companyForm.zip = this.maskZip(this.companyForm.zip);
                this.companyForm.phone = this.maskPhone(this.companyForm.phone);
                this.companyForm.state = String(this.companyForm.state || '').toUpperCase();
            });
        },
        async fetchEmailSettings() {
            if (!this.isAdmin) return;
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/email-settings');
                const data = resp.data || {};
                this.emailSettingsForm = { ...this.emptyEmailSettings(), ...data, password: '' };
            });
        },
        async fetchTechniciansAll() {
            if (!this.isAdmin) return;
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/users', { params: { all: 1, role: 'tecnico' } });
                this.techniciansAll = resp.data || [];
            });
        },
        async fetchUsers(page = 1) {
            if (!this.isAdmin) return;
            return await this.withPageLoading(async () => {
                const params = {
                    page,
                    per_page: 10,
                    q: this.users.filters.q || '',
                    role: this.users.filters.role || '',
                };
                const resp = await axios.get('/api/users', { params });
                const p = this.normalizePaginated(resp);
                this.users.items = p.items;
                this.users.page = p.page;
                this.users.lastPage = p.lastPage;
            });
        },
        normalizePaginated(resp) {
            const body = resp.data || {};
            return {
                items: body.data || [],
                page: body.current_page || 1,
                lastPage: body.last_page || 1,
            };
        },
        async fetchClients(page = 1) {
            return await this.withPageLoading(async () => {
                const params = { page, per_page: 10, q: this.clients.filters.q || '' };
                const resp = await axios.get('/api/clients', { params });
                const p = this.normalizePaginated(resp);
                this.clients.items = p.items;
                this.clients.page = p.page;
                this.clients.lastPage = p.lastPage;
            });
        },
        async fetchServices(page = 1) {
            return await this.withPageLoading(async () => {
                const params = { page, per_page: 10, q: this.services.filters.q || '' };
                const resp = await axios.get('/api/services', { params });
                const p = this.normalizePaginated(resp);
                this.services.items = p.items;
                this.services.page = p.page;
                this.services.lastPage = p.lastPage;
            });
        },
        async fetchOrders(page = 1) {
            return await this.withPageLoading(async () => {
                const params = {
                    page,
                    per_page: 10,
                    q: this.orders.filters.q || '',
                    status: this.orders.filters.status || '',
                    client_id: this.orders.filters.client_id || '',
                    from: this.orders.filters.from || '',
                    to: this.orders.filters.to || '',
                };
                const resp = await axios.get('/api/orders', { params });
                const p = this.normalizePaginated(resp);
                this.orders.items = p.items;
                this.orders.page = p.page;
                this.orders.lastPage = p.lastPage;
            });
        },
        async fetchClientsAll() {
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/clients', { params: { all: 1 } });
                this.clientsAll = resp.data || [];
            });
        },
        async fetchServicesAll() {
            return await this.withPageLoading(async () => {
                const resp = await axios.get('/api/services', { params: { all: 1 } });
                this.servicesAll = resp.data || [];
            });
        },
        onCompanyLogoChange(e) {
            const input = e && e.target ? e.target : null;
            const file = input && input.files && input.files[0] ? input.files[0] : null;
            if (!file) return;

            if (input && input.nextElementSibling) {
                input.nextElementSibling.textContent = file.name;
            }

            const reader = new FileReader();
            reader.onload = () => {
                this.companyForm.logo_image = reader.result;
                if (!this.company) this.company = {};
                this.company.logo_image = reader.result;
            };
            reader.readAsDataURL(file);
        },
        async saveCompany() {
            this.touchAll('company');
            if (this.companyHasErrors) {
                this.setAlert('Verifique os campos do cadastro da empresa.');
                return;
            }
            if (!this.isAdmin) {
                this.setAlert('Somente administrador pode alterar os dados da empresa.');
                return;
            }

            this.ui.loading = true;
            try {
                const payload = { ...this.companyForm };
                await axios.put('/api/company', payload);
                this.setNotice('Empresa atualizada.');
                await this.fetchCompany();
            } catch (e2) {
                this.setAlert(this.apiErrorMessage(e2));
            } finally {
                this.ui.loading = false;
            }
        },
        async saveEmailSettings() {
            this.touchAll('email');
            if (this.emailSettingsHasErrors) {
                this.setAlert('Verifique os campos da configuração de e-mail.');
                return;
            }
            if (!this.isAdmin) {
                this.setAlert('Somente administrador pode alterar as configurações de e-mail.');
                return;
            }

            this.ui.loading = true;
            try {
                const f = this.emailSettingsForm || {};
                const enabled = Boolean(f.enabled);
                const host = String(f.host || '').trim();
                const rawPort = String(f.port || '').trim();
                const port = rawPort ? parseInt(rawPort, 10) : null;
                const username = String(f.username || '').trim();
                const encryption = String(f.encryption || '').trim();
                const from = String(f.from_address || '').trim();
                const fromName = String(f.from_name || '').trim();

                const payload = {
                    enabled,
                    mailer: 'smtp',
                    host: host || null,
                    port: port,
                    username: username || null,
                    password: String(f.password || ''),
                    encryption: encryption || null,
                    from_address: from || null,
                    from_name: fromName || null,
                };
                const resp = await axios.put('/api/email-settings', payload);
                const data = resp.data || {};
                this.emailSettingsForm = { ...this.emptyEmailSettings(), ...data, password: '' };
                this.setNotice('Configuração de e-mail salva.');
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        debouncedFetchClients() {
            clearTimeout(this.timers.clients);
            this.timers.clients = setTimeout(() => this.fetchClients(1), 350);
        },
        debouncedFetchServices() {
            clearTimeout(this.timers.services);
            this.timers.services = setTimeout(() => this.fetchServices(1), 350);
        },
        debouncedFetchOrders() {
            clearTimeout(this.timers.orders);
            this.timers.orders = setTimeout(() => this.fetchOrders(1), 350);
        },
        debouncedFetchUsers() {
            clearTimeout(this.timers.users);
            this.timers.users = setTimeout(() => this.fetchUsers(1), 350);
        },
        openClientModal(client = null) {
            this.ui.modalError = '';
            this.touched.client = {};
            this.clientForm = client ? { ...client } : this.emptyClient();
            this.clientForm.document = this.maskCpfCnpj(this.clientForm.document);
            this.clientForm.phone = this.maskPhone(this.clientForm.phone);
            this.clientForm.zip = this.maskZip(this.clientForm.zip);
            $('#clientModal').modal('show');
        },
        async saveClient() {
            this.touchAll('client');
            if (this.clientHasErrors) {
                this.ui.modalError = 'Verifique os campos do formulário.';
                return;
            }

            this.ui.loading = true;
            this.ui.modalError = '';
            try {
                const payload = { ...this.clientForm };
                if (payload.id) {
                    await axios.put(`/api/clients/${payload.id}`, payload);
                    this.setNotice('Cliente atualizado.');
                } else {
                    await axios.post('/api/clients', payload);
                    this.setNotice('Cliente criado.');
                }
                $('#clientModal').modal('hide');
                await this.fetchClients(this.clients.page);
                await this.fetchClientsAll();
            } catch (e) {
                this.setModalError(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async deleteClient(client) {
            if (!confirm(`Excluir cliente "${client.name}"?`)) return;
            try {
                await axios.delete(`/api/clients/${client.id}`);
                this.setNotice('Cliente excluído.');
                await this.fetchClients(this.clients.page);
                await this.fetchClientsAll();
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            }
        },
        openServiceModal(service = null) {
            this.ui.modalError = '';
            this.touched.service = {};
            this.serviceForm = service ? { ...service } : this.emptyService();
            this.serviceForm.value = service ? this.currencyToInput(service.value) : '';
            $('#serviceModal').modal('show');
        },
        async saveService() {
            this.touchAll('service');
            if (this.serviceHasErrors) {
                this.ui.modalError = 'Verifique os campos do formulário.';
                return;
            }

            this.ui.loading = true;
            this.ui.modalError = '';
            try {
                const payload = {
                    ...this.serviceForm,
                    value: this.parseCurrency(this.serviceForm.value),
                };
                if (payload.id) {
                    await axios.put(`/api/services/${payload.id}`, payload);
                    this.setNotice('Serviço atualizado.');
                } else {
                    await axios.post('/api/services', payload);
                    this.setNotice('Serviço criado.');
                }
                $('#serviceModal').modal('hide');
                await this.fetchServices(this.services.page);
                await this.fetchServicesAll();
            } catch (e) {
                this.setModalError(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async deleteService(service) {
            if (!confirm(`Excluir serviço "${service.name}"?`)) return;
            try {
                await axios.delete(`/api/services/${service.id}`);
                this.setNotice('Serviço excluído.');
                await this.fetchServices(this.services.page);
                await this.fetchServicesAll();
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            }
        },
        openUserModal(user = null) {
            this.ui.modalError = '';
            this.touched.user = {};
            this.userForm = user ? { ...user, password: '' } : this.emptyUser();
            if (!this.userForm.role) this.userForm.role = 'tecnico';
            if (this.userForm.role !== 'cliente') this.userForm.client_id = '';
            $('#userModal').modal('show');
        },
        async saveUser() {
            this.touchAll('user');
            if (this.userHasErrors) {
                this.ui.modalError = 'Verifique os campos do formulário.';
                return;
            }

            this.ui.loading = true;
            this.ui.modalError = '';
            try {
                const payload = {
                    name: this.userForm.name,
                    email: this.userForm.email,
                    role: this.userForm.role,
                    client_id: this.userForm.role === 'cliente' ? this.userForm.client_id : null,
                };
                if (this.userForm.password) payload.password = this.userForm.password;

                if (this.userForm.id) {
                    await axios.put(`/api/users/${this.userForm.id}`, payload);
                    this.setNotice('Usuário atualizado.');
                } else {
                    if (!payload.password) {
                        this.ui.modalError = 'Senha é obrigatória.';
                        return;
                    }
                    await axios.post('/api/users', payload);
                    this.setNotice('Usuário criado.');
                }

                $('#userModal').modal('hide');
                await this.fetchUsers(this.users.page);
                await this.fetchTechniciansAll();
            } catch (e) {
                this.setModalError(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async deleteUser(user) {
            if (!confirm(`Excluir usuário "${user.name}"?`)) return;
            try {
                await axios.delete(`/api/users/${user.id}`);
                this.setNotice('Usuário excluído.');
                await this.fetchUsers(this.users.page);
                await this.fetchTechniciansAll();
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            }
        },
        serviceById(id) {
            const sid = Number(id);
            return (this.servicesAll || []).find((s) => Number(s.id) === sid) || null;
        },
        addServiceToOrder(service) {
            if (!service || !service.id) return;
            const sid = Number(service.id);
            if (!this.orderForm.selected.includes(sid)) {
                this.orderForm.selected.push(sid);
            }
            if (!this.orderForm.quantities[sid]) {
                this.orderForm.quantities[sid] = 1;
            }
            this.orderServiceSearch = '';
            this.touch('order', 'services');
            this.recalcOrderTotal();
        },
        removeServiceFromOrder(serviceId) {
            const sid = Number(serviceId);
            this.orderForm.selected = (this.orderForm.selected || []).filter((x) => Number(x) !== sid);
            if (this.orderForm.quantities && Object.prototype.hasOwnProperty.call(this.orderForm.quantities, sid)) {
                delete this.orderForm.quantities[sid];
            }
            this.touch('order', 'services');
            this.recalcOrderTotal();
        },
        lineTotalPreview(serviceId, unitValue) {
            const selected = this.orderForm.selected.includes(serviceId);
            if (!selected) return 0;
            const qty = Number(this.orderForm.quantities[serviceId] || 1);
            return Number(unitValue || 0) * qty;
        },
        recalcOrderTotal() {
            let total = 0;
            for (const sid of (this.orderForm.selected || [])) {
                const s = this.serviceById(sid);
                if (!this.orderForm.quantities[sid]) this.orderForm.quantities[sid] = 1;
                total += this.lineTotalPreview(sid, s ? s.value : 0);
            }
            this.orderForm.total_preview = total;
        },
        startSignatureFromList(order) {
            this.ui.modalError = '';
            this.touched.order = {};
            this.orderForm = this.emptyOrder();
            this.signatureComponent = null;

            this.orderForm.id = order.id;
            this.orderForm.number = order.number;
            this.orderForm.status = order.status;
            this.orderForm.original_status = order.status;
            this.orderForm.signature_image = '';

            this.openSignatureModal();
        },
        openCloseOrderModal(order) {
            this.openOrderModal(order, true);
        },
        openOrderModal(order = null, closeMode = false) {
            this.ui.modalError = '';
            this.touched.order = {};
            this.orderForm = this.emptyOrder();
            this.signatureComponent = null;
            this.orderServiceSearch = '';
            this.orderCloseMode = Boolean(closeMode);

            if (order) {
                this.orderForm.id = order.id;
                this.orderForm.number = order.number;
                this.orderForm.client_id = order.client_id;
                this.orderForm.responsible_user_id = order.responsible_user_id || '';
                this.orderForm.status = order.status;
                this.orderForm.original_status = order.status;
                this.orderForm.opened_at = this.toDatetimeLocal(order.opened_at);
                this.orderForm.notes = order.notes || '';
                this.orderForm.solution = order.solution || '';
                this.orderForm.signature_image = order.signature_image || '';
            } else {
                this.orderForm.opened_at = this.toDatetimeLocal(new Date().toISOString());
                this.orderCloseMode = false;
            }

            this.orderForm.quantities = {};
            this.orderForm.selected = [];
            this.recalcOrderTotal();

            if (order) {
                axios.get(`/api/orders/${order.id}`).then((resp) => {
                    const full = resp.data;
                    const selected = [];
                    const quantities = {};
                    if (full && full.services) {
                        for (const s of full.services) {
                            selected.push(s.id);
                            quantities[s.id] = Number((s.pivot && s.pivot.quantity) || 1);
                        }
                    }
                    this.orderForm.selected = selected;
                    this.orderForm.quantities = { ...this.orderForm.quantities, ...quantities };
                    this.orderForm.signature_image = full.signature_image || this.orderForm.signature_image || '';
                    this.orderForm.responsible_user_id = full.responsible_user_id || this.orderForm.responsible_user_id || '';
                    this.orderForm.solution = full.solution || this.orderForm.solution || '';
                    this.recalcOrderTotal();
                });
            }

            $('#orderModal').modal('show');
        },
        async saveOrder() {
            this.touch('order', 'client_id');
            this.touch('order', 'services');
            this.touchAll('order');
            if (this.orderHasErrors) {
                this.ui.modalError = 'Verifique os campos do formulário.';
                return;
            }

            if (this.orderForm.status === 'cancelada' && this.orderForm.original_status !== 'cancelada') {
                const ok = confirm('Confirmar CANCELAMENTO desta OS?');
                if (!ok) return;
            }

            this.ui.loading = true;
            this.ui.modalError = '';
            try {
                const servicesPayload = this.orderForm.selected.map((id) => ({
                    id,
                    quantity: Number(this.orderForm.quantities[id] || 1),
                }));

                const payload = {
                    client_id: this.orderForm.client_id,
                    status: this.orderForm.status,
                    opened_at: this.orderForm.opened_at ? new Date(this.orderForm.opened_at).toISOString() : null,
                    notes: this.orderForm.notes || null,
                    solution: this.orderForm.solution || null,
                    signature_image: this.orderForm.signature_image || null,
                    services: servicesPayload,
                };
                if (this.isAdmin) {
                    payload.responsible_user_id = this.orderForm.responsible_user_id || null;
                }

                let saved;
                if (this.orderForm.id) {
                    saved = await axios.put(`/api/orders/${this.orderForm.id}`, payload);
                    this.setNotice('OS atualizada.');
                } else {
                    saved = await axios.post('/api/orders', payload);
                    this.setNotice('OS criada.');
                }

                const savedOrder = saved && saved.data;
                if (savedOrder && savedOrder.status === 'finalizada') {
                    await this.downloadOrderPdf(savedOrder.id, savedOrder.number);
                }

                $('#orderModal').modal('hide');
                await this.fetchOrders(this.orders.page);
                if (this.isAdmin) {
                    await this.fetchDashboard();
                }
            } catch (e) {
                this.setModalError(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async downloadOrderPdf(orderId, orderNumber) {
            try {
                const resp = await axios.get(`/api/orders/${orderId}/pdf`, { responseType: 'blob' });
                const blob = new Blob([resp.data], { type: 'application/pdf' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                const safe = String(orderNumber || orderId).toString().padStart(6, '0');
                a.href = url;
                a.download = `OS-${safe}.pdf`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                this.setNotice('PDF gerado com sucesso.');
            } catch (e) {
                this.setAlert('Não foi possível baixar o PDF.');
            }
        },
        async finalizeOrderWithSignature(orderId, orderNumber, image) {
            this.ui.loading = true;
            try {
                await axios.put(`/api/orders/${orderId}`, { status: 'finalizada', signature_image: image });
                await this.fetchOrders(this.orders.page);
                if (this.isAdmin) {
                    await this.fetchDashboard();
                }
                await this.downloadOrderPdf(orderId, orderNumber);
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            } finally {
                this.ui.loading = false;
            }
        },
        async deleteOrder(order) {
            if (!confirm(`Excluir OS #${order.number}?`)) return;
            try {
                await axios.delete(`/api/orders/${order.id}`);
                this.setNotice('OS excluída.');
                await this.fetchOrders(this.orders.page);
                if (this.isAdmin) {
                    await this.fetchDashboard();
                }
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            }
        },
        async viewOrder(order) {
            try {
                const resp = await axios.get(`/api/orders/${order.id}`);
                this.orderView = resp.data;
                $('#orderViewModal').modal('show');
            } catch (e) {
                this.setAlert(this.apiErrorMessage(e));
            }
        },
        setViewFromHash() {
            const defaultHash = this.isAdmin ? '#/dashboard' : '#/orders';
            const h = (location.hash || defaultHash).replace('#/', '');
            if (['dashboard', 'clients', 'services', 'orders', 'company', 'email', 'users'].includes(h)) {
                if (!this.isAdmin && h !== 'orders') {
                    this.currentView = 'orders';
                    return;
                }
                this.currentView = h;
                if (h === 'email') {
                    this.fetchEmailSettings();
                }
                if (h === 'users') {
                    this.fetchUsers(1);
                }
            } else {
                this.currentView = this.isAdmin ? 'dashboard' : 'orders';
            }
        },
        async bootstrapData() {
            await this.loadMe();
            await this.fetchCompany();
            await this.fetchOrders(1);
            if (this.isAdmin) {
                await this.fetchDashboard();
                await this.fetchTechniciansAll();
                await this.fetchClientsAll();
                await this.fetchServicesAll();
                await this.fetchClients(1);
                await this.fetchServices(1);
            } else if (this.isTechnician) {
                await this.fetchClientsAll();
                await this.fetchServicesAll();
            }
            this.setViewFromHash();
        }
    },
    async mounted() {
        this.setAuthHeader();
        window.addEventListener('hashchange', () => this.setViewFromHash());
        this.setViewFromHash();
        $('#signatureModal').on('hidden.bs.modal', () => {
            this.signatureComponent = null;
            const root = document.getElementById('signatureRoot');
            if (root) root.innerHTML = '';
        });
        if (this.auth.token) {
            await this.bootstrapData();
        }
    }
}).mount('#app');
</script>
</body>
</html>
