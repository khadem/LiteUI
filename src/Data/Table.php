<?php
namespace LiteUI\Data;
use LiteUI\Core\Component;

class Table extends Component
{
    public function __construct(array $columns, array $rows)
    {
        parent::__construct('div', '', array('class' => 'lu-table-wrap'));
        $table = $this->add(new Component('table'));
        $header = $table->add(new Component('thead'))->add(new Component('tr'));
        foreach ($columns as $label) { $header->add(new Component('th', $label, array('scope' => 'col'))); }
        $body = $table->add(new Component('tbody'));
        foreach ($rows as $row) {
            $tr = $body->add(new Component('tr'));
            foreach ($columns as $key => $label) { $tr->add(new Component('td', isset($row[$key]) ? $row[$key] : '')); }
        }
    }
}
