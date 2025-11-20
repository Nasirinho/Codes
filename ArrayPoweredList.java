


public class ArrayPoweredList<I extends Comparable<? super I>> implements ListInterface<I> {
    private static final int INITIAL_CAPACITY = 10;
    private I[] data;
    private int size;

    @SuppressWarnings("unchecked")
    public ArrayPoweredList() {
        data = (I[]) new Comparable[INITIAL_CAPACITY];
        size = 0;
    }

    @Override
    public ListInterface<I> copy() {
        ArrayPoweredList<I> copyList = new ArrayPoweredList<>();
        for (int i = 0; i < this.size; i++) {
            copyList.add(this.data[i]);
        }
        return copyList;
    }
    @Override
    public int size() {
        return size;
    }

    @Override
    public boolean isEmpty() {
        return size == 0;
    }

    @Override
    public void add(I element) {
    	if (element == null) {
    	    throw new NullPointerException("Cannot add null element to the list.");
    	}
        
        if (this.isFull()) {
        	this.resize();
        }
        this.data[this.size] = element;
        this.size++;
    }

   

	@Override
    public void add(I element, int index) {
        if (index < 0 || index > size) {
            throw new IndexOutOfBoundsException("Invalid index: " + index);
        }
        if (element == null) {
    	    throw new NullPointerException("Cannot add null element to the list.");
    	}
        if (this.isFull()) {
        	this.resize();
        }
        if (this.isEmpty() || index == size) {
			this.add(element);
		} else {
			
			for (int i = this.size; i > index; i--) {
				this.data[i] = this.data[i - 1];
			}
			
			this.data[index] = element;
			this.size++;

		}
    }

    @Override
    public I get(int index) {
    	if (index < 0 || index >= size) {
            throw new IndexOutOfBoundsException("Invalid index: " + index);
        }
        return (I)data[index];
    }

    @Override
    public I replace(I element, int index) {
    	if (index < 0 || index >= size) {
            throw new IndexOutOfBoundsException("Invalid index: " + index);
        }
        I old = data[index];
        data[index] = element;
        return old;
    }

    @Override
    public I remove(int index) {
    	if (index < 0 || index >= size) {
            throw new IndexOutOfBoundsException("Invalid index: " + index);
        }
        I removed = (I) data[index];
        if(this.size == 1) {
			this.removeAll();
		}else if(index == this.size - 1) {
			this.size--;
		}else {
			// shift first to the to the front
			
			for(int i = index; i < this.size; i++) {
				this.data[i] = this.data[i + 1];
			}
			this.size--;
		}
		
		return removed;
    }

    @SuppressWarnings("unchecked")
	@Override
    public void removeAll() {
        this.data = (I[]) new Comparable[this.data.length];
        this.size = 0;
    }

    
    public boolean isFull() {
    	return (this.size == this.data.length);
    }
    
    @SuppressWarnings("unchecked")
   	private void resize() {
   		I [] dataCopy = (I[]) new Comparable[this.data.length * 2];
   		
   		for (int i = 0; i < data.length; i++) {
   			dataCopy[i] = data[i];
   		}
   		
   		data = (I[]) dataCopy;
   		
   	}

 }
