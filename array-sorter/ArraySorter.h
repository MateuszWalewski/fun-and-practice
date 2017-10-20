#include <iostream>
#include <ctime>
#include <unistd.h>
#include <stdlib.h>

using namespace std;




class ArraySorter
{
    int numberOfElements;
    int* tab;

public:

ArraySorter(int, int[]);
~ArraySorter();

//sorting algorithms
void insertion_sort();
void selection_sort();
void bubbleSort();
void quicksort(int, int);
void fusion(int, int, int);
void mergeSort( int, int);
bool checkIfSorted();
void displayArray();
void undoSort(int[]);

};
