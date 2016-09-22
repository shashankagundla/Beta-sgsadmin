<?php
/**
 * VFM - veno file manager: include/list-folders.php
 * list folders inside curret directory
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2016 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */

/**
* List Folders
*/
if ($gateKeeper->isAccessAllowed()) { 

    $cleandir = "?dir=".substr($setUp->getConfig('starting_dir').$gateKeeper->getUserInfo('dir'), 2);
    $stolink = $encodeExplorer->makeLink(false, null, $location->getDir(false, true, false, 1));
    $stodeeplink = $encodeExplorer->makeLink(false, null, $location->getDir(false, true, false, 0));

    if (strlen($stolink) > strlen($cleandir)) {
            $parentlink = $encodeExplorer->makeLink(false, null, $location->getDir(false, true, false, 1));
    } else {
            $parentlink = "?dir=";
    }
    if (strlen($stodeeplink) > strlen($cleandir)
        && $setUp->getConfig("show_path") !== true
    ) { ?>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $parentlink; ?>">
                    <i class="fa fa-angle-left"></i> <i class="fa fa-folder-open"></i>
                </a>
            </li>
        </ol>
    <?php
    } ?>
    <script src="vfm-admin/js/datatables.min.js"></script>
    <?php    
    // Ready to display folders.
    if ($encodeExplorer->dirs) { ?>
        <section class="vfmblock tableblock ghost ghost-hidden">
            <table class="table" width="100%" id="sortable">
                <thead>
                    <tr class="rowa two">
                        <td></td>
                        <td class="mini"><span class="sorta nowrap"><i class="fa fa-sort-alpha-asc"></i></span></td>
                        <td class="mini hidden-xs"><span class="sorta nowrap"><i class="fa fa-calendar"></i></span></td>
                        <?php
                        if ($location->editAllowed()) {
                            // edit column
                            if ($gateKeeper->isAllowed('rename_dir_enable')) { ?>
                                <td class="mini del text-center col-xs-1">
                                    <i class="fa fa-pencil"></i>
                                </td>
                            <?php 
                            }
                            // delete column
                            if ($gateKeeper->isAllowed('delete_dir_enable')) { ?>
                                <td class="mini del text-center col-xs-1">
                                    <i class="fa fa-trash-o"></i>
                                </td>
                            <?php 
                            } 
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
        <?php
        foreach ($encodeExplorer->dirs as $dir) {

            $dirpath = $dir->getLocation().$dir->getName();
            $dirdatatime = filemtime($dirpath);
            $dirtime = $setUp->formatModTime($dirdatatime);
            $nameencoded = $dir->getNameEncoded();
            $locationDir = $location->getDir(false, true, false, 0);
            $del = $locationDir.$nameencoded;
            $thislink = $encodeExplorer->makeLink(false, null, $del);
            $thisdel = $encodeExplorer->makeLink(false, $del, $locationDir);
            $thisdir = urldecode($locationDir);
            ?>
                    <tr class="rowa">
            <?php 
            if ($setUp->getConfig("show_folder_counter") === true) {
                $quanti = Utils::countContents($location->getDir(false, false, false, 0).$dir->getName());
                $quantifiles = $quanti['files'];
                $quantedir = $quanti['folders']; ?>
                        <td class="icon nowrap folder-badges">
                            <a href="<?php echo $thislink; ?>">
                                <span class="badge">
                                    <i class="fa fa-folder-o"></i> 
                                    <?php echo $quantedir; ?>
                                </span>
                                <span class="badge">
                                    <i class="fa fa-files-o"></i> 
                                    <?php echo $quantifiles; ?>
                                </span> 
                            </a>
                        </td>
            <?php   
            } else { ?>
                        <td></td>
            <?php
            } ?>
                        <td class="name" data-order="<?php echo $dir->getName(); ?>">
                            <div class="relative">
                                <a class="full-lenght" href="<?php echo $thislink; ?>">
                                    <span class="icon text-center">
                                        <i class="fa fa-folder fa-lg"></i>
                                    </span> 
                                    <?php echo $dir->getName(); ?>
                                </a>
                                <span class="hover">
                                    <i class="fa fa-folder-open-o fa-fw"></i>
                                </span>
                            </div>
                        </td>

                        <td class="hidden-xs mini reduce nowrap" data-order="<?php echo $dirdatatime; ?>">
                            <?php echo $dirtime; ?>
                        </td>

            <?php
            if ($location->editAllowed()) {
                if ($gateKeeper->isAllowed('rename_dir_enable')) { ?>
                        <td class="icon text-center rename">
                            <a class="round-butt butt-mini" href="javascript:void(0)" data-thisdir="<?php echo $thisdir; ?>" 
                                data-thisname="<?php echo $dir->getName(); ?>">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                        </td>
                <?php
                }
                if ($gateKeeper->isAllowed('delete_dir_enable')) {
                    $delquery = base64_encode($del);
                    $cash = md5($delquery.$setUp->getConfig('salt').$setUp->getConfig('session_name')); ?>

                        <td class="del text-center">
                            <a class="round-butt butt-mini" data-name="<?php echo $dir->getName(); ?>" 
                                href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>&fa=<?php echo $delquery; ?>">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                <?php
                } 
            } ?>
                    </tr>
        <?php
        } ?>
                </tbody>
            </table>
        </section>
    <?php    
    }

    $dirpaginate = 'off';
    if ($setUp->getConfig("show_pagination_folders") == true) { 
        $dirpaginate = 'on';
    }
    // list by date
    if ($setUp->getConfig('folderdeforder') == "date") { 
        $tbSortcol = 2;
        $tbSortdir = 'desc';
        // list by name
    } else { 
        $tbSortcol = 1;
        $tbSortdir = 'asc';
    } 
    if ($setUp->getConfig("show_pagination_num_folder") == true) { 
        $sPaginationTypeF = 'full_numbers';
    } else {
        $sPaginationTypeF = 'simple';
    }
    $iDisplayLengthF = $setUp->getConfig('folderdefnum');
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            callFoldersTable(
                '<?php echo $sPaginationTypeF; ?>', 
                <?php echo $iDisplayLengthF; ?>, 
                <?php echo $tbSortcol; ?>, 
                '<?php echo $tbSortdir; ?>',
                '<?php echo $dirpaginate; ?>'
            );
        });
    </script>
<?php
    
} ?>