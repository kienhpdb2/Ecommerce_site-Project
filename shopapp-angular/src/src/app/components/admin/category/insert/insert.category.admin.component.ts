import { Component } from '@angular/core';
import { InsertCategoryDTO } from 'src/app/dtos/category/insert.category.dto';
import { Category } from 'src/app/models/category';
import { Product } from 'src/app/models/product';
import { ActivatedRoute, Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';
import { ProductService } from 'src/app/services/product.service';
import { OnInit } from '@angular/core';
@Component({
  selector: 'app-insert.category.admin',
  templateUrl: './insert.category.admin.component.html',
  styleUrls: ['./insert.category.admin.component.scss']
})
export class InsertCategoryAdminComponent implements OnInit {
  insertCategoryDTO: InsertCategoryDTO = {
    name: '',    
  };
  categories: Category[] = []; // Dữ liệu động từ categoryService
  constructor(    
    private route: ActivatedRoute,
    private router: Router,
    private categoryService: CategoryService,    
    private productService: ProductService,    
  ) {
    
  } 
  ngOnInit() {
    
  }   

  insertCategory() {    
    this.categoryService.insertCategory(this.insertCategoryDTO).subscribe({
      next: (response) => {
        debugger
        this.router.navigate(['/admin/categories']);        
      },
      error: (error) => {
        debugger
        // Handle error while inserting the category
        alert(error.error)
        console.error('Error inserting category:', error);
      }
    });    
  }
}
