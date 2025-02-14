<?php
    include 'db.php';

    $sql = "SELECT * FROM notes";
    $result = $conn->query($sql);

    if($result->num_rows>0)
    {
        while($row=$result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>".$row["notesId"]."</td>";
            echo "<td>".$row["title"]."</td>";
            echo "<td>".$row["content"]."</td>";
            echo "<td>".$row["date"]."</td>";
            echo "<td>
                    <a href='update_form.php?notesId=".$row["notesId"]." 'class = 'btn btn-warning'>Edit</a>
                    <a href='delete.php?notesId=".$row["notesId"]." 'class = 'btn btn-danger'>Delete</a>
                 </td>";
            echo "</tr>";

        }
    }
    else{
        echo "No notes found.";
    }
    $conn->close();
?>