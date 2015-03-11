<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="backoffice.php">LibriOnLine - Pannello di amministrazione</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
            	<li><a href="manager-user-profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Torna al sito</a>
                </li>
                {if $admin}
                <li>
                    <a href="#"><i class="fa fa-book fa-fw"></i> Gestione Libri<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="manager-books.php"><strong> Gestione Libri</strong></a></li>
                        <li><a href="manager-authors.php"> Gestione Autori</a></li>
                        <li><a href="manager-editors.php"> Gestione Editori</a></li>
                        <li><a href="manager-languages.php"> Gestione Lingue</a></li>
                        <li><a href="manager-tags.php"> Gestione Tags</a></li>
                        <li><a href="manager-electronic-copies.php"> Gestione Copie Elettroniche</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-tasks fa-fw"></i> Gestione Volumi<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="manager-volumes.php"><strong> Gestione Volumi</strong></a></li>
                        <li><a href="manager-conditions.php"> Gestione Condizioni</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bell fa-fw"></i> Gestione Prestiti<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="manager-loans.php"><strong> Gestione Prestiti</strong></a></li>
                        <li><a href="manager-loans.php?pid=1"> Prestiti Attivi</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-user fa-fw"></i> Gestione Utenti<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="manager-users.php"><strong> Gestione Utenti</strong></a></li>
                        <li><a href="manager-groups.php"> Gestione Gruppi</a></li>
                        <li><a href="manager-services.php"> Gestione Servizi</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                {else}
                <li>
                    <a href="#"><i class="fa fa-file fa-fw"></i> Storico prestiti<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="manager-loans-users.php"><strong> Storico prestiti</strong></a></li>
                        <li><a href="manager-loans-users.php?pid=1"> Prestiti attivi</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
               	{/if}
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>