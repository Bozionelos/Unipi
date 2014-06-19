/*
 ============================================================================
 Name        : mpi1.c
 Author      : John Paraskakis
 Version     :
 Copyright   : Your copyright notice
 Description : Hello MPI World in C 
 ============================================================================
 */
#include <stdio.h>
#include <string.h>
#include <stdbool.h>
#include "mpi.h"
#include <stddef.h>

//Global Variables
int my_rank;
int p;

//Struct for 2D coordinates
typedef struct Point {
   int x;
   int y;
} Point;



// Methods
// Searching around a point for neighbors;
int search_all(char B[][20], Point temp, Point buffer[],int *buffer_pointer);

// Checking if a point is already in buffer
int check_for_loops(Point temp, Point buffer[],int *buffer_pointer);

// Find the first point indicating a new object has been found
void local_neighbours(char A[][20],int p,int myrank);

//Expanding the first point to detect the whole object
void find_objects(char B[][20],int i,int j,char let);

//Display a 2D table
void my_table(char A[][20], int i, int j,int rank);

// Possible Objects
char letters[20]={'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O'};

//Display one dimension array
void print_array_int(int array[],int count);
void print_array(char array[],int count);

//Empty buffers
void empty_letters(char A[],int count);
void empty_pointers(int letter[],int count);



void my_table(char A[][20], int row, int col,int rank){
	int i,j;
	char data;
	int count=0;
	printf(" Local Table in Processor %d\n",rank);
	printf("0  | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 |10 |11 |12 |13 |14 |15 |16 |17 |18 |19 |20 |\n");
	printf("------------------------------------------------------------------------------------\n");
	for (i=0;i<row;i++){
		if(i+1<10){
		printf("%d  |",i+1);
		}
		else{
		printf("%d |",i+1);
		}

		for (j=0;j<col;j++){
			data = A[i][j];
			if(data=='0'){
				data=' ';
			}
			count++;
			printf(" %c |",data);
		}
		printf("\n");
		if(i==3 || i==7 || i==11 || i==15 || i==19){
				printf("------------------------------------------------------------------------------------\n");
				}
	}

}

void local_neighbours(char A[][20],int p,int myrank){
	int i,j;
	int char_pointer = myrank*2;
	int count=0;
	for(int i=0;i<20/p;i++){
		for(int j=0;j<20;j++){
			if(A[i][j]=='1'){		//If the pixel needs to be labeled
				find_objects(A,i,j,letters[char_pointer]);  //Find the object containing that pixel
				count++;
				if(count<3){
					char_pointer++;
				}
				else{
					char_pointer = myrank+6; //Change letter for the different objects
				}

			}

		}
	}



}
void find_objects(char B[][20],int row,int col,char let){
	int boolnext =1;

	Point buffer[100]={};

	//Head and tail indexes in buffer
	int buffer_pointer, visited_pointer;

	//Head and tail pointing at the same index
	buffer_pointer=visited_pointer=0;

	//first point to expand
	Point temp = {row,col};
	buffer[buffer_pointer]=temp;
	buffer_pointer++;

	//If we have another object to expand
	while(visited_pointer<buffer_pointer){

		//Expand by checking the neighbors and label. Advance to the next index
		buffer_pointer=search_all(B, buffer[visited_pointer],buffer, &buffer_pointer);
		Point labeled = buffer[visited_pointer];
		visited_pointer++;
		B[labeled.x][labeled.y]=let;


	}

}

//Checking for objects that are already expanded
int check_for_loops(Point temp, Point buffer[],int *buffer_pointer){
	int check=0;
	Point temp2;
	for(int i=0;i<*(buffer_pointer);i++){
		temp2= buffer[*buffer_pointer];
		if(temp.x == temp2.x && temp.y==temp2.y){
			check=1;

		}
	}
	return check;
}

int search_all(char B[][20], Point temp, Point buffer[],int *buffer_pointer){


	int size = *buffer_pointer;

	//Search North
	if (temp.x>0){
		if(B[temp.x-1][temp.y] == '1'){
			Point temp2 = {(temp.x)-1,temp.y};

			int check = check_for_loops(temp2,buffer,buffer_pointer);
			if(check==0){
			buffer[size]=temp2;
			size++;
			}
		}
	}

	//Search South
	if (temp.x < 4){
		if (B[temp.x+1][temp.y] =='1'){
			Point temp2={(temp.x)+1,temp.y};
			int check = check_for_loops(temp2,buffer,buffer_pointer);
			if(check==0){
			buffer[size]=temp2;
			size++;
			}
		}
	}

	//Search East
	if (temp.y < 20){
			if (B[temp.x][temp.y+1] =='1'){

				Point temp2={temp.x,(temp.y)+1};

				int check = check_for_loops(temp2,buffer,buffer_pointer);
					if(check==0){
					buffer[size]=temp2;
					size++;
					}
			}
	}

	//Search West
		if (temp.y >0){
				if (B[temp.x][temp.y-1] =='1'){
					Point temp2={temp.x,(temp.y)-1};

				int check = check_for_loops(temp2,buffer,buffer_pointer);
						if(check==0){
						buffer[size]=temp2;
						size++;
						}
				}
	}

		return size;
}



void empty_letters(char letter[],int count){
	for(int i=0;i<count;i++){
		letter[i]=' ';
	}
}
void empty_pointers(int index[],int count){
	for(int i=0;i<count;i++){
		index[i]=-1;
	}
}
void print_array(char array[],int count){
	for(int i=0;i<count;i++){
		printf("%c|",array[i]);
	}
	printf("\n");
}
void print_array_int(int array[],int count){
	for(int i=0;i<count;i++){
		printf("%d|",array[i]);
	}
	printf("\n");
}


int main(int argc, char* argv[]){

	int source;   /* rank of sender */
	int dest;     /* rank of receiver */
	int tag=0;    /* tag for messages */
	int num_r;
	int num_c;

	MPI_Status status ;   /* return status for receive */
	
	/* start up MPI */
	
	MPI_Init(&argc, &argv);
	
	/* find out process rank */
	MPI_Comm_rank(MPI_COMM_WORLD, &my_rank); 
	
	/* find out number of processes */
	MPI_Comm_size(MPI_COMM_WORLD, &p); 
	
	//local table
	char B[20/p][20];

	if (my_rank !=0){

		MPI_Recv(&(B[0][0]), 20*(20/p), MPI_CHAR, 0, 0, MPI_COMM_WORLD, &status);
		char (*pointer)[20]=B;

		//Apply search for objects
		local_neighbours(pointer,p,my_rank);
		MPI_Barrier(MPI_COMM_WORLD);

		//MPI_Send(&(B[0][0]), 20*(20/p), MPI_CHAR, 0, 1, MPI_COMM_WORLD);

	}


	else if (my_rank==0){

		//Our initial world unlabeled
		char map[20][20] = {
		{ '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'},
		{ '0', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'},
		{ '0', '1', '1', '1', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1', '1', '1', '0'},
		{ '0', '1', '1', '1', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '1', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '1', '1', '1', '0', '0', '0', '0', '1', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '1', '1', '1', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0'},
		{ '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '0'},
		{ '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '0'},
		{ '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'},
		{ '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'},
		};

		//number of rows per processor
		num_r = 20/p;
		//number of columns per processor
		num_c = 20;

		//Passing the strips to each processor
		for (int i=1;i<p;i++){
			MPI_Send(&(map[(i*(20/p))][0]), 20*(20/p), MPI_CHAR, i, 0, MPI_COMM_WORLD);
		}


		MPI_Barrier(MPI_COMM_WORLD);

		//Fetch the strip to local table for processor 0
		for(int i=0;i<(20/p);i++){
			for(int j=0;j<20;j++){
				B[i][j]=map[i][j];
			}
		}

		char (*pointer)[20]=B;

		//Apply search for objects for processor 0
		local_neighbours(pointer,p,my_rank);

		/*
		for(int i=1;i<p;i++){
			MPI_Recv(&(map[(i*4)][0]), 20*(20/p), MPI_CHAR, i, 1, MPI_COMM_WORLD, &status);
		}*/
		for(int i=0;i<(20/p);i++){
				for(int j=0;j<20;j++){
					map[i][j]=B[i][j];
				}
		}

	}

	//Common Code
	MPI_Barrier(MPI_COMM_WORLD);

	MPI_Bcast(&num_r,1,MPI_INT, 0, MPI_COMM_WORLD);
	MPI_Bcast(&num_c, 1, MPI_INT, 0, MPI_COMM_WORLD);



	/*************************Passing letters from above to bellow**************************************/
	int max,total_checks;
	char letter_to_change;
	int search,j;
	int count = 0;
	char buffer_to_send[num_c];
	int buffer_pointers[num_c];
	char data[num_c];
	int data_pointers[20];
	empty_letters(buffer_to_send,num_c);
	empty_pointers(buffer_pointers,num_c);
	char frontier_let;


	// Finding the letters and their indexes that need to be sent to other processors
	for(int i=0;i<p-1;i++){
		if(my_rank<p-1 && my_rank>=i){
			for(int j=0;j<num_c;j++){
				if(B[num_r-1][j]!='0'){
					frontier_let=B[num_r-1][j];
					buffer_to_send[count] = frontier_let;
					buffer_pointers[count] = j;
					count++;
				}

		}


		//Table buffer to send contains the letters of the last row of each local table
		MPI_Send(&buffer_to_send, count, MPI_CHAR, my_rank+1, 1, MPI_COMM_WORLD);
		//Table buffer pointers contains the indexes of the buffer letters
		MPI_Send(&buffer_pointers, count, MPI_INT, my_rank+1, 1, MPI_COMM_WORLD);
		}
		//We pass the letters which are on the last row of every local table to the next proccessor
		MPI_Barrier(MPI_COMM_WORLD);
		if(my_rank>=i+1){
			MPI_Recv(&data, num_c, MPI_CHAR, my_rank-1, 1, MPI_COMM_WORLD, &status);
			MPI_Recv(&data_pointers, num_c, MPI_INT, my_rank-1, 1, MPI_COMM_WORLD, &status);
			total_checks=0;
				for(int i=0;i<num_c;i++){
					if(data_pointers[i]>-1){
						total_checks++;
					}
				}

			//Apply changes for each step
			for(int i=0;i<total_checks;i++){
				j = data_pointers[i];
					if(B[0][j]!='0'){
						letter_to_change = B[0][j];
							for(int a=0;a<20/p;a++){
								for(int b=0;b<20;b++){
									if(B[a][b]==letter_to_change){
										B[a][b]=data[i];
									}
								}
							}
					}
			}


			count=0;

		}
	}

	MPI_Barrier(MPI_COMM_WORLD);
	empty_letters(buffer_to_send,num_c);
	empty_pointers(buffer_pointers,num_c);
	empty_letters(data,num_c);
	empty_pointers(data_pointers,num_c);
	/*************************Passing letters from bellow to above**************************************/

				//Every processor searches for letters in the top row and adds them and their pointers in the buffer
				for(int i=p-1;i>0;i--){
					if(my_rank>0 && my_rank<=i){
						for(int j=0;j<num_c;j++){
							if(B[0][j]!='0'){
								frontier_let=B[0][j];
								buffer_to_send[count] = frontier_let;
								buffer_pointers[count] = j;
								count++;
							}
						}

					//Table buffer to send contains the letters of the first row of each local table
					MPI_Send(&buffer_to_send, count, MPI_CHAR, my_rank-1, 1, MPI_COMM_WORLD);
					//Table buffer pointers contains the indexes of the buffer letters
					MPI_Send(&buffer_pointers, count, MPI_INT, my_rank-1, 1, MPI_COMM_WORLD);
					}
					//We pass the letters which are on the first row of every local table to the next processor
					MPI_Barrier(MPI_COMM_WORLD);
					if(my_rank<i-1){
						MPI_Recv(&data, num_c, MPI_CHAR, my_rank+1, 1, MPI_COMM_WORLD, &status);
						MPI_Recv(&data_pointers, num_c, MPI_INT, my_rank+1, 1, MPI_COMM_WORLD, &status);
						total_checks=0;
							for(int i=0;i<num_c;i++){
								if(data_pointers[i]>0){
									total_checks++;
								}
							}
						//Apply changes for each step
						for(int i=0;i<total_checks;i++){
							j = data_pointers[i];
								if(B[num_r-1][j]!='0' && B[num_r-1][j]!=data[i]){
									letter_to_change = B[num_r-1][j];
										for(int a=0;a<20/p;a++){
											for(int b=0;b<20;b++){
												if(B[a][b]==letter_to_change){
													B[a][b]=data[i];
												}
											}
										}
								}
						}

					}
					empty_letters(buffer_to_send,num_c);
				    empty_pointers(buffer_pointers,num_c);
					empty_letters(data,num_c);
					empty_pointers(data_pointers,num_c);
					count=0;
				}


	/*************************************************************************************************/

	//Re-Assembly the map
	if(my_rank!=0){
		MPI_Send(&(B[0][0]), num_c*(num_r), MPI_CHAR, 0, 2, MPI_COMM_WORLD);
	}
	else{
		char map[20][20];
			for(int i=1;i<p;i++){  // to be changed with mpi gather
				MPI_Recv(&(map[(i*4)][0]), num_c*(num_r), MPI_CHAR, i, 2, MPI_COMM_WORLD, &status);
			}
			for(int i=0;i<num_r;i++){
				for(int j=0;j<num_c;j++){
					map[i][j]=B[i][j];
				}
			}
			my_table(map,20,20,my_rank);

	}
	/***************************************************************************************************/
	/* shut down MPI */
	MPI_Finalize(); 
	
	
	return 0;
};


