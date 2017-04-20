<?php



//该类为分页工具类
class PageTool
{
    /*
     * $url 分页链接的url
     * $count 总条数
     * $page 当前页码
     * $pageSize 每页的条数
     *
     *
     */

    public function show($url,$count,$page,$pageSize){
        //根据条件获取总页数
        $total_page = ceil($count/$pageSize);
        //计算上一页
        $page = $page>$total_page?$total_page:$page;
        $page = $page<0?1:$page;
        $pre_page = $page==1?1:$page-1;
        //计算下一页
        $next_page = $page==$total_page?$total_page:$page+1;
        $pageHtml = <<<xxxx

        <table id="page-table" cellspacing="0">
            <tbody>
            <tr>
                <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                    <div id="turn-page">
                        总计  <span id="totalRecords">{$count}</span>个记录分为 <span id="totalPages">{$total_page}</span>页当前第 <span id="pageCurrent">{$page}</span>
                        页，每页 <input type="text" size="3" id="pageSize" value="{$pageSize}" onkeypress="return listTable.changePageSize(event)">
                        <span id="page-link">
                            <a href="{$url}&page=1">第一页</a>
                            <a href="{$url}&page={$pre_page}">上一页</a>
                            <a href="{$url}&page={$next_page}">下一页</a>
                            <a href="{$url}&page={$total_page}">最末页</a>
                            <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
                                <option value="1">1</option><option value="2">2</option>          </select>
                        </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
xxxx;
        return $pageHtml;
    }
}